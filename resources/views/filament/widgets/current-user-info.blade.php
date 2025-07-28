<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center space-x-4">
            <!-- User Avatar -->
            <div class="flex-shrink-0">
                @if($this->getUser()->avatar)
                    <img src="{{ $this->getUser()->avatar }}"
                         alt="{{ $this->getUser()->first_name }}"
                         class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                @else
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-xl font-bold">
                        {{ strtoupper(substr($this->getUser()->first_name, 0, 1)) }}{{ strtoupper(substr($this->getUser()->last_name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <!-- User Information -->
            <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-2">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ $this->getUser()->first_name }} {{ $this->getUser()->last_name }}
                    </h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        {{ $this->getUser()->email }}
                    </span>
                </div>

                <div class="mt-2 space-y-1">
                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="font-medium">Roles:</span>
                        <span class="ml-1">{{ $this->getUserRoles() }}</span>
                    </div>

                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Member Since:</span>
                        <span class="ml-1">{{ $this->getMemberSince() }}</span>
                    </div>

                    @if($this->getUser()->phone)
                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span class="font-medium">Phone:</span>
                        <span class="ml-1">{{ $this->getUser()->phone }}</span>
                    </div>
                    @endif

                    @if($this->getUser()->address)
                    <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium">Address:</span>
                        <span class="ml-1">{{ $this->getUser()->address }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="flex-shrink-0">
                <div class="flex space-x-2">
                    <a href="{{ route('filament.admin.resources.users.edit', $this->getUser()->id) }}"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
