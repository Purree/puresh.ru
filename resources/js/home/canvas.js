document.addEventListener("DOMContentLoaded", function () {

    let canvas, canvasColor, ctx, circ, nodes, mouse, SENSITIVITY, SIBLINGS_LIMIT, DENSITY, NODES_QTY, ANCHOR_LENGTH,
        MOUSE_RADIUS, wrappedElementsCoordinates;

    // how close next node must be to activate connection (in px)
    // shorter distance == better connection (line width)
    SENSITIVITY = 100;
    // note that siblings limit is not 'accurate' as the node can actually have more connections than this value that's because the node accepts sibling nodes with no regard to their current connections this is acceptable because potential fix would not result in significant visual difference
    // more siblings == bigger node
    SIBLINGS_LIMIT = 10;
    // default node margin
    DENSITY = 50;
    // total number of nodes used (incremented after creation)
    NODES_QTY = 0;
    // avoid nodes spreading
    ANCHOR_LENGTH = 20;
    // highlight radius
    MOUSE_RADIUS = 250;

    circ = 2 * Math.PI;
    nodes = [];

    canvas = document.querySelector('canvas');
    updateCanvasColor();
    updateWrappedElementsCoordinates();

    resizeWindow();
    mouse = {
        x: canvas.width / 2, y: canvas.height / 2
    };
    ctx = canvas.getContext('2d');

    if (!ctx) {
        alert("Ваш браузер не поддерживает canvas.");
    }

    function updateCanvasColor()
    {
        canvasColor = window.getComputedStyle(document.querySelector("canvas"))["color"];
    }

    function updateWrappedElementsCoordinates()
    {
        wrappedElementsCoordinates = [];
        const wrappedElements = [".main-information-block"];

        wrappedElements.forEach((tag) => {
            const element = document.querySelector(tag);
            const elementCoordinates = element.getBoundingClientRect();
            const elementStyles = window.getComputedStyle(element);
            const x = elementCoordinates.x - parseInt(elementStyles['marginLeft']) - parseInt(elementStyles['paddingLeft'])
            const y = elementCoordinates.y - parseInt(elementStyles['marginTop']) - parseInt(elementStyles['paddingTop'])
            const width = elementCoordinates.width + parseInt(elementStyles['marginLeft']) + parseInt(elementStyles['marginRight'])
                + parseInt(elementStyles['paddingLeft']) + parseInt(elementStyles['paddingRight'])
            const height = elementCoordinates.height + parseInt(elementStyles['marginTop']) + parseInt(elementStyles['marginBottom'])
                + parseInt(elementStyles['paddingTop']) + parseInt(elementStyles['paddingBottom'])

            wrappedElementsCoordinates.push({"tag": tag, "x": x, "y": y, "width": width, "height": height});
        })
    }

    function getNodeColor(brightness)
    {
        const canvasRBGValues = canvasColor.split("(")[1].split(")")[0].split(", ")

        return `rgba(${canvasRBGValues[0]}, ${canvasRBGValues[1]}, ${canvasRBGValues[2]}, ${brightness})`
    }

    function Node(x, y)
    {
        this.anchorX = x;
        this.anchorY = y;
        this.x = Math.random() * (x - (x - ANCHOR_LENGTH)) + (x - ANCHOR_LENGTH);
        this.y = Math.random() * (y - (y - ANCHOR_LENGTH)) + (y - ANCHOR_LENGTH);
        this.vx = Math.random() * 2 - 1;
        this.vy = Math.random() * 2 - 1;
        this.energy = Math.random() * 100;
        this.radius = Math.random();
        this.siblings = [];
        this.brightness = 0;
    }

    Node.prototype.drawNode = function () {
        const color = getNodeColor(this.brightness);
        ctx.beginPath();
        ctx.arc(this.x, this.y, 2 * this.radius + 2 * this.siblings.length / SIBLINGS_LIMIT, 0, circ);
        ctx.fillStyle = color;
        ctx.fill();
    };

    Node.prototype.drawConnections = function () {
        for (const element of this.siblings) {
            const color = getNodeColor(this.brightness);
            ctx.beginPath();
            ctx.moveTo(this.x, this.y);
            ctx.lineTo(element.x, element.y);
            ctx.lineWidth = 1 - calcDistance(this, element) / SENSITIVITY;
            ctx.strokeStyle = color;
            ctx.stroke();
        }
    };

    Node.prototype.moveNode = function () {
        this.energy -= 2;
        if (this.energy < 1) {
            this.energy = Math.random() * 100;
            if (this.x - this.anchorX < -ANCHOR_LENGTH) {
                this.vx = Math.random() * 2;
            } else if (this.x - this.anchorX > ANCHOR_LENGTH) {
                this.vx = Math.random() * -2;
            } else {
                this.vx = Math.random() * 4 - 2;
            }
            if (this.y - this.anchorY < -ANCHOR_LENGTH) {
                this.vy = Math.random() * 2;
            } else if (this.y - this.anchorY > ANCHOR_LENGTH) {
                this.vy = Math.random() * -2;
            } else {
                this.vy = Math.random() * 4 - 2;
            }
        }

        wrappedElementsCoordinates.forEach((el) => {
            // If node inside wrapped element
            if ((this.x >= el['x'] && this.x <= (el['x'] + el['width'])) && (this.y >= el['y'] && this.y <= (el['y'] + el['height']))) {
                const left = Math.abs(this.x - el['x'])
                const right = Math.abs(this.x - (el['x'] + el['width']))
                const top = Math.abs(this.y - el['y'])
                const bottom = Math.abs(this.y - (el['y'] + el['height']))

                // true - dot nearer vertical, false - horizontal
                if (Math.abs(left - right) < Math.abs(top - bottom)) {
                    // true - nearer to top, false - bottom
                    this.y = top < bottom ? el['y'] : el['y'] + el['height']
                } else {
                    // true - nearer to left, false - right
                    this.x = left < right ? el['x'] : el['x'] + el['width']
                }
            }
        })

        this.x += this.vx * this.energy / 100;
        this.y += this.vy * this.energy / 100;
    };

    function initNodes()
    {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        nodes = [];

        if (screen.width < 480) {
            return;
        }

        for (let i = DENSITY; i < canvas.width; i += DENSITY) {
            for (let j = DENSITY; j < canvas.height; j += DENSITY) {
                nodes.push(new Node(i, j));
                NODES_QTY++;
            }
        }
    }

    function calcDistance(node1, node2)
    {
        return Math.sqrt(Math.pow(node1.x - node2.x, 2) + (Math.pow(node1.y - node2.y, 2)));
    }

    function findSiblings()
    {
        let node1, node2, distance;
        for (let i = 0; i < NODES_QTY; i++) {
            node1 = nodes[i];
            node1.siblings = [];
            for (let j = 0; j < NODES_QTY; j++) {
                node2 = nodes[j];
                if (node1 !== node2) {
                    distance = calcDistance(node1, node2);
                    if (distance < SENSITIVITY) {
                        if (node1.siblings.length < SIBLINGS_LIMIT) {
                            node1.siblings.push(node2);
                        } else {
                            let node_sibling_distance = 0;
                            let max_distance = 0;
                            let s;
                            for (let k = 0; k < SIBLINGS_LIMIT; k++) {
                                node_sibling_distance = calcDistance(node1, node1.siblings[k]);
                                if (node_sibling_distance > max_distance) {
                                    max_distance = node_sibling_distance;
                                    s = k;
                                }
                            }
                            if (distance < max_distance) {
                                node1.siblings.splice(s, 1);
                                node1.siblings.push(node2);
                            }
                        }
                    }
                }
            }
        }
    }

    function redrawScene()
    {
        resizeWindow();
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        findSiblings();
        let i, node, distance;
        for (i = 0; i < NODES_QTY; i++) {
            node = nodes[i];
            distance = calcDistance({
                x: mouse.x, y: mouse.y
            }, node);
            if (distance < MOUSE_RADIUS) {
                node.brightness = 1 - distance / MOUSE_RADIUS;
            } else {
                node.brightness = 0;
            }
        }
        for (i = 0; i < NODES_QTY; i++) {
            node = nodes[i];
            if (node.brightness) {
                node.drawNode();
                node.drawConnections();
            }
            node.moveNode();
        }
        requestAnimationFrame(redrawScene);
    }

    function initHandlers()
    {
        window.addEventListener('resize', resizeWindowHandler, false);
        document.addEventListener('mousemove', mousemoveHandler, false);
        document.addEventListener('changeTheme', updateCanvasColor, false);
        document.addEventListener('touchmove', touchmoveHandler, false);
    }

    function resizeWindowHandler()
    {
        updateWrappedElementsCoordinates();
        resizeWindow();
    }

    function resizeWindow()
    {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }

    function mousemoveHandler(e)
    {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    }

    function touchmoveHandler(e)
    {
        mouse.x = e.touches[0].clientX;
        mouse.y = e.touches[0].clientY;
    }

    initHandlers();
    initNodes();
    redrawScene();

});
