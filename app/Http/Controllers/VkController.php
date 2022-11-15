<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkVKRequest;
use App\Services\Integrations\VK;
use Illuminate\Http\RedirectResponse;
use Throwable;

class VkController extends Controller
{
    public function __construct(protected VK $vk)
    {
    }

    public function link(LinkVKRequest $request): RedirectResponse
    {
        try {
            $this->vk->link($request->code);
        } catch (Throwable $e) {
            return redirect()->route('profile.settings')->with('error', $e->getMessage());
        }

        return redirect()->route('profile.settings')->with('success', 'VK account linked');
    }

    public function unlink(): RedirectResponse
    {
        try {
            $this->vk->unlink();
        } catch (Throwable $e) {
            return redirect()->route('profile.settings')->with('error', $e->getMessage());
        }

        return redirect()->route('profile.settings')->with('success', 'VK account unlinked');
    }
}
