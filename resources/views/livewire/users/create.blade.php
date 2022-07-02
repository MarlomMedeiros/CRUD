<div class="sm:mx-28 sm:mt-16">
    <div class="mx-48">
        <div class="mt-5 md:mt-0">
            <form wire:submit.prevent="create">
                @csrf
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <x-jet-validation-errors class="mb-4"/>
                        <div>
                            <label class="block text-sm font-medium text-gray-700"> Photo </label>
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
                                        {{ __('Select A New Photo') }}
                                    </x-jet-secondary-button>

                                    @if ($this->user->profile_photo_path)
                                        <x-jet-secondary-button type="button" class="mt-2"
                                                                wire:click="deleteProfilePhoto">
                                            {{ __('Remove Photo') }}
                                        </x-jet-secondary-button>
                                    @endif

                                    <x-jet-input-error for="photo" class="mt-2"/>
                                </div>
                            @endif
                        </div>

                        <div x-data class="grid grid-cols-6 mt-2 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="name" class="block text-sm font-medium text-gray-700">First name</label>
                                <input wire:model.defer="user.name" type="text" id="name" autocomplete="name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
                                <input wire:model.defer="user.last_name" type="text" name="last_name" id="last_name"
                                       autocomplete="last_name"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                                <input wire:model.defer="user.email" type="text" name="email" id="email"
                                       autocomplete="email"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>

                                <input wire:model.defer="user.cpf" type="text" x-mask="999.999.999-99"
                                       placeholder="999.999.999-95" name="cpf" id="cpf" autocomplete="cpf"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input wire:model.defer="password" type="password"
                                       autocomplete="password"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="birthday" class="block text-sm font-medium text-gray-700">Birthday</label>
                                <input type="date" placeholder="DD/MM/YYYY" wire:model.defer="user.birthday"
                                       name="birthday" id="birthday" autocomplete="birthday"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <select wire:model.defer="address.country" id="country" name="country"
                                        autocomplete="country"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="Brazil">Brazil</option>
                                    <option value="Portugal">Portugal</option>
                                </select>
                            </div>

                            <div class="col-span-3">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input wire:model.defer="user.phone" type="text" x-mask="(99) 9999-9999"
                                       placeholder="(99) 9999-9999" id="phone" name="phone" autocomplete="phone"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-4">
                                <label for="street-address" class="block text-sm font-medium text-gray-700">Street
                                    address</label>
                                <input wire:model.defer="address.address" type="text" name="street-address"
                                       id="street-address" autocomplete="street-address"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                <label for="postal-code" class="block text-sm font-medium text-gray-700">ZIP / Postal
                                    code</label>
                                <input wire:model.defer="address.zip" type="text" x-mask="99999-999"
                                       placeholder="0000-000" name="postal-code" id="postal-code"
                                       autocomplete="postal-code"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>


                            <div class="col-span-6 sm:col-span-6 lg:col-span-3">
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input wire:model.defer="address.city" type="text" name="city" id="city"
                                       autocomplete="address-level2"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>

                            <div class="col-span-6 sm:col-span-3 lg:col-span-3">
                                <label for="region" class="block text-sm font-medium text-gray-700">State /
                                    Province</label>
                                <input wire:model.defer="address.state" type="text" name="region" id="region"
                                       autocomplete="address-level1"
                                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>


                        </div>
                    </div>
                    <div class="flex justify-end items-center px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <x-jet-action-message class="mr-3" on="created">
                            {{ __('Created.') }}
                        </x-jet-action-message>
                        <button type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
