  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <nav class="bg-[#384B70]">
      <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
          <div class="relative flex h-16 items-center justify-between">
              <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                  <!-- Mobile menu button-->
                  <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                      <span class="absolute -inset-0.5"></span>
                      <span class="sr-only">Open main menu</span>

                      <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                      </svg>
                  </button>
              </div>
              <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                  <div class="flex shrink-0 items-center">
                      <x-application-logo />
                  </div>
                  <div class="hidden sm:ml-6 sm:block">
                      <div class="flex space-x-4">
                          <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                          @auth
                          <a href="{{ url('/dashboard') }}"
                              class="rounded-md {{ request()->is('dashboard') ? 'bg-gray-900 text-white' : 'text-[#FCFAEE] hover:bg-gray-700 hover:text-white' }} 
                                px-3 py-2 text-sm font-medium" aria-current="page" aria-current="page">Dashboard</a>
                          @else
                          <a href="{{ url('/dashboard') }}"
                              class="rounded-md {{ request()->is('dashboard') ? 'bg-gray-900 text-white' : 'text-[#FCFAEE] hover:bg-gray-700 hover:text-white' }} 
                                px-3 py-2 text-sm font-medium" aria-current="page" aria-current="page">log in</a>
                          @endauth

                          <a href={{url('/home')}}
                              class="rounded-md {{ request()->is('home') ? 'bg-gray-900 text-white' : 'text-[#FCFAEE] hover:bg-gray-700 hover:text-white' }} 
                                  px-3 py-2 text-sm font-medium">home page</a>
                          <a href={{url('/taste')}}
                              class="rounded-md {{ request()->is('your taste') ? 'bg-gray-900 text-white' : 'text-[#FCFAEE] hover:bg-gray-700 hover:text-white' }} 
                                 px-3 py-2 text-sm font-medium">your taste</a>
                          <a href="#" hidden class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white content-end">Calendar</a>

                      </div>

                  </div>
                  @if (!auth()->check())
                  <div class="-mx-3 flex flex-1 justify-end">
                      <a href="{{ route('register') }}" class="rounded-md mt-1 mb-3 px-3 py-2 text-sm font-medium text-[#FCFAEE] hover:bg-gray-700 hover:text-white">register</a>
                  </div>
                  @endif

              </div>

          </div>
      </div>

      <!-- Mobile menu, show/hide based on menu state. -->
      <div class="sm:hidden" id="mobile-menu">
          <div class="space-y-1 px-2 pb-3 pt-2">
              <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

              <a href="{{url('/dashboard')}}"
                  class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Dashboard</a>
              <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">home page</a>
              <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">your taste</a>
              <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white hidden">Calendar</a>
          </div>
      </div>

  </nav>