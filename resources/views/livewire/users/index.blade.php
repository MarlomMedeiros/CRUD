<div class="lg:mx-32 mt-3">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">@lang('Users')</h1>
                <p class="mt-2 text-sm text-gray-700">@lang('A list of all the users in your account including their name, title, email and role.')</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route ('users.create') }}" type="button"
                   class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                    @lang('Add user')
                </a>
            </div>
        </div>
        <div class="mt-4 lg:grid lg:grid-cols-4 lg:gap-4">
            <x-input wire:model.debounce.500ms="search" class="lg:col-span-3" placeholder="@lang('Search')" />
        </div>
        <div class="mt-4 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col">
                                    <div class="flex py-3.5 pl-4 pr-3 text-left text-sm items-center font-semibold text-gray-900">
                                        <a class="mr-1">@lang('First Name')</a>
                                        <x-icon wire:click="orderBy('name','asc')" name="arrow-up" class="cursor-pointer  w-3 h-3" solid />
                                        <x-icon wire:click="orderBy('name','desc')" name="arrow-down" class="cursor-pointer mx-0.5 w-3 h-3" solid />
                                    </div>
                                </th>

                                <th scope="col">
                                    <div class="flex py-3.5 text-left text-sm items-center font-semibold text-gray-900">
                                        <a class="mr-1">@lang('Last Name')</a>
                                        <x-icon wire:click="orderBy('last_name','asc')" name="arrow-up" class="cursor-pointer w-3 h-3" solid />
                                        <x-icon wire:click="orderBy('last_name','desc')" name="arrow-down" class="cursor-pointer mx-0.5 w-3 h-3" solid />
                                    </div>
                                </th>

                                <th scope="col">
                                    <div class="flex py-3.5 pl-4 pr-3 text-left text-sm items-center font-semibold text-gray-900">
                                        <a class="mr-1">@lang('Email')</a>
                                        <x-icon wire:click="orderBy('email','asc')" name="arrow-up" class="cursor-pointer w-3 h-3" solid />
                                        <x-icon wire:click="orderBy('email','desc')" name="arrow-down" class="cursor-pointer mx-0.5 w-3 h-3" solid />
                                    </div>
                                </th>

                                <th scope="col">
                                    <div class="flex py-3.5 text-left text-sm items-center font-semibold text-gray-900">
                                        <a class="mr-1">@lang('Birthday')</a>
                                        <x-icon wire:click="orderBy('birthday','asc')" name="arrow-up" class="cursor-pointer w-3 h-3" solid />
                                        <x-icon wire:click="orderBy('birthday','desc')" name="arrow-down" class="cursor-pointer mx-0.5 w-3 h-3" solid />
                                    </div>
                                </th>

                                <th scope="col">
                                    <div class="flex py-3.5 text-left text-sm items-center font-semibold text-gray-900">
                                        <a class="mr-1">@lang('Create Date')</a>
                                        <x-icon wire:click="orderBy('created_at','asc')" name="arrow-up" class="cursor-pointer w-3 h-3" solid />
                                        <x-icon wire:click="orderBy('created_at','desc')" name="arrow-down" class="cursor-pointer mx-0.5 w-3 h-3" solid />
                                    </div>
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"/>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($users as $user)
                                <tr class="odd:bg-white even:bg-slate-50">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->last_name }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::createFromTimestamp(strtotime($user->birthday))->format('d/m/Y') }}</td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::createFromTimestamp(strtotime($user->created_at))->format('d/m/Y à\s H:i:s') }}</td>
                                    <td class="flex justify-end py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                        <a href="{{ route ('users.show', ['user' => $user->id]) }}"
                                           class="mx-1 text-indigo-600 hover:text-indigo-900">
                                            @lang('View')
                                        </a>
                                        <a href="{{ route ('users.edit', ['user' => $user->id]) }}"
                                           class="mx-1 text-indigo-600 hover:text-indigo-900">
                                            @lang('Edit')
                                        </a>
                                        <livewire:users.delete :user="$user" wire:key="user::{{ $user->id }}"/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="ml-2">{{ $users->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>