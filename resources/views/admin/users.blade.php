<x-admin-panel>
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
            <div class="row">
                <div class="col-sm-12 table-responsive">
                    <table id="example2" class="table table-bordered dataTable dtr-inline" role="grid"
                           aria-describedby="example2_info">
                        <thead>
                        <tr role="row" class="table-dark">
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Mail verification date') }}</th>
                            <th>{{ __('Photo') }}</th>
                            @foreach($permissions as $permission)
                                <th>
                                    {{ __(ucfirst($permission)) }}
                                </th>
                            @endforeach
                            <th colspan="2">{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr class="table-dark">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->email_verified_at ?? __('Not verified') }}</td>
                                <td><img class="rounded-circle" width="32" height="32" src="{{ $user->profile_photo_url }}" alt="{{ $user->profile_photo_url }}"/></td>
                                @foreach($permissions as $permission)
                                    <td>
                                    {{ \App\Policies\PermissionPolicy::isUserHasPermission($user, $permission) ? __('True') : __('False') }}
                                    </td>
                                @endforeach
                                <td><a href="{{ route('admin.editUser', ['userId'=>$user->id]) }}" class="btn btn-warning">{{ __('Edit') }}</a></td>
                                <td><livewire:admin.delete-user :user="$user" :page="request()->fullUrl()"/></td>  {{-- Удаление --}}
                            </tr>

                            @if ($user->notes->isNotEmpty())
                                <tr class="bg-primary text-center">
                                    <td colspan="11">
                                        {{ __('Notes') }}
                                    </td>
                                </tr>
                            @endif

                            @foreach($user->notes as $note)
                                <tr class="bg-primary">
                                    <td>{{ $note->id }}</td>
                                    <td colspan="9">{{ $note->title }}</td>
                                    <td><a href="{{ route('notes.edit', ['id'=>$note->id]) }}" class="btn btn-warning">{{ __('Edit') }}</a></td>
                                </tr>
                            @endforeach

                            @if ($user->sessions->isNotEmpty())
                                <tr class="bg-info text-center">
                                    <td colspan="11">
                                        {{ __('Sessions') }}
                                    </td>
                                </tr>
                            @endif
                            @foreach($user->sessions as $session)
                                <tr class="bg-info">
                                    <td colspan="4">{{ __('Last active') . ': ' . $session->formated_last_activity }}</td>
                                    <td colspan="5">{{ __('Expires') . ': ' . $session->expires_at }}</td>
                                    <td colspan="1">{{ $session->ip_address }}</td>
                                    <td><livewire:admin.delete-session :session="$session" :page="request()->fullUrl()"/></td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $users->onEachSide(1)->links() }}
            </div>
        </div>
</x-admin-panel>
