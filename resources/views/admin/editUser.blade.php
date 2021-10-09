<x-app-layout>
    <livewire:admin.edit-user :user="$user" :permissions="$permissions" :page="request()->fullUrl()"/>
</x-app-layout>
