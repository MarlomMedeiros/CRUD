<div class="sm:mx-28 sm:mt-16">
    <div class="lg:mx-48">
        <div class="mt-5 md:mt-0">
            <form wire:submit.prevent="save">
                @csrf
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <x-errors class="mb-2" title="{{ __('We found {errors} validation error(s)') }}"/>
                        <div>
                            <label class="block text-sm font-medium text-gray-700"> @lang('Photo') </label>
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <div x-data="{photoName: null, photoPreview: null}"
                                     class="flex items-center col-span-6 sm:col-span-4">
                                    <!-- Profile Photo File Input -->
                                    <input type="file" class="hidden"
                                           wire:model="photo"
                                           x-ref="photo"
                                           x-on:change="
                                                        photoName = $refs.photo.files[0].name;
                                                        const reader = new FileReader();
                                                        reader.onload = (e) => {
                                                            photoPreview = e.target.result;
                                                        };
                                                        reader.readAsDataURL($refs.photo.files[0]);
                                                "/>
                                    <!-- Current Profile Photo -->
                                    <div class="mt-2" x-show="! photoPreview">
                                        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                                             class="rounded-full h-20 w-20 object-cover">
                                    </div>

                                    <!-- New Profile Photo Preview -->
                                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                                        <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                                              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                                        </span>
                                    </div>

                                    <x-jet-secondary-button class="mt-2 mx-2" type="button"
                                                            x-on:click.prevent="$refs.photo.click()">
                                        @lang('Select Photo')
                                    </x-jet-secondary-button>

                                    @if ($this->user->profile_photo_path)
                                        <x-jet-secondary-button type="button" class="mt-2"
                                                                wire:click="deleteProfilePhoto">
                                            @lang('Remove Photo')
                                        </x-jet-secondary-button>
                                    @endif

                                    <x-jet-input-error for="photo" class="mt-2"/>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-6 mt-2 gap-6">

                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">@lang('First Name')</label>
                                <input wire:model.defer="user.name" type="text" id="name" name="name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">@lang('Last Name')</label>
                                <input wire:model.defer="user.last_name" type="text" name="last_name" id="family-name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">@lang('Email address')</label>
                                <input wire:model.defer="user.email" type="text" name="email" id="email"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <x-inputs.maskable
                                        wire:model.defer="user.cpf"
                                        label="{{ __('CPF') }}"
                                        mask="###.###.###-##"
                                        name="cpf"
                                        placeholder="{{ __('CPF') }}"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700">@lang('Country')</label>
                                <select wire:model.defer="address.country" id="country" name="country"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="Brazil">@lang('Brazil')</option>
                                    <option value="Portugal">@lang('Portugal')</option>
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="birthday" class="block text-sm font-medium text-gray-700">@lang('Birthday')</label>
                                <input type="date" placeholder="@lang('DD/MM/YYYY')" wire:model.defer="user.birthday"
                                       name="birthday" id="birthday"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-6 lg:col-span-3">
                                <label for="street-address" class="block text-sm font-medium text-gray-700">@lang('Street address')</label>
                                <input wire:model.defer="address.address" type="text" name="street-address"
                                       id="street-address"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-6 lg:col-span-3">
                                <x-inputs.maskable
                                        wire:model.defer="user.phone"
                                        label="{{ __('Phone Number') }}"
                                        mask="['+## ####-####']"
                                        name="phone"
                                        placeholder="{{ __('Phone Number') }}"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                <label for="city" class="block text-sm font-medium text-gray-700">@lang('City')</label>
                                <input wire:model.defer="address.city" type="text" name="city" id="city"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="region" class="block text-sm font-medium text-gray-700">@lang('State')</label>
                                <input wire:model.defer="address.state" type="text" name="region" id="region"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <x-inputs.maskable
                                        wire:model.defer="address.zip"
                                        label="{{ __('Zip Code') }}"
                                        mask="#####-###"
                                        name="Zip Code"
                                        placeholder="{{ __('Zip Code') }}"
                                />
                        </div>
                    </div>
                </div>
                <div class="flex justify-end items-center px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <x-jet-action-message class="mr-3" on="save">
                        @lang('Saved')
                    </x-jet-action-message>
                    <x-jet-button type="submit" wire:loading.attr="disabled" wire:target="photo">
                        @lang('Save')
                    </x-jet-button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
