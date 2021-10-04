<x-app-layout>
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12 col-md-6"></div>
                <div class="col-sm-12 col-md-6"></div>
            </div>
            <div class="row">
                <div class="col-sm-12 table-responsive">
                    <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" role="grid"
                           aria-describedby="example2_info">
                        <thead>
                        <tr role="row">
                            <th>ID</th>
                            <th>Ник</th>
                            <th>Почта</th>
                            <th>Дата верификации почты</th>
                            <th>Аватарка</th>
                            @foreach($permissions as $permission)
                                <th>
                                    {{ $permission }}
                                </th>
                            @endforeach
                            <th colspan="2">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->email_verified_at ?? 'Не верифицирован' }}</td>
                                <td><img class="rounded-circle" width="32" height="32" src="{{ $user->profile_photo_url }}" alt="{{ $user->profile_photo_url }}"/></td>
                                @foreach($permissions as $permission)
                                    <td>
                                    {{ $user->permissions->$permission ? 'true' : 'false' }}
                                    </td>
                                @endforeach
                                <td><button class="btn btn-warning">Редактировать</button></td>
                                <td><button data-id="{{ $user->id }}" class="btn btn-danger">Удалить</button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->onEachSide(1)->links() }}
            </div>
        </div>
</x-app-layout>
