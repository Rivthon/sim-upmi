<div class="flex items-center justify-between p-5 border-b border-gray-200">
    <div class="text-2xl font-extrabold text-blue-600">
        SIM UPMI
    </div>
    {{-- Tombol Close ini hanya ada di mobile (overlay). Di desktop, toggle ada di header utama --}}
    <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

<nav class="flex-1 p-4 space-y-2 overflow-y-auto">
    {{-- Dashboard --}}
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center px-4 py-2 rounded-lg text-base font-medium
              {{ request()->routeIs('admin.dashboard') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
              transition duration-200 ease-in-out">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
        Dashboard
    </a>

    {{-- Manajemen User --}}
    <a href="{{ route('admin.user.index') }}"
       class="flex items-center px-4 py-2 rounded-lg text-base font-medium
              {{ request()->routeIs('admin.user.*') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
              transition duration-200 ease-in-out">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
        Manajemen User
    </a>
    {{-- Kategori Dokumen --}}
    <a href="{{ route('admin.kategori.index') }}"
       class="flex items-center px-4 py-2 rounded-lg text-base font-medium
              {{ request()->routeIs('admin.kategori.*') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
              transition duration-200 ease-in-out">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm1.414-.586a1 1 0 011.414 0L9 7.086V5a1 1 0 112 0v2.086l2.172-2.172a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414zM10 12a1 1 0 100 2h4a1 1 0 100-2h-4z" clip-rule="evenodd"></path></svg>
        Kategori Dokumen
    </a>
    {{-- Dokumen Mutu (Semua Dokumen) --}}
    <a href="{{ route('admin.dokumen.index') }}"
       class="flex items-center px-4 py-2 rounded-lg text-base font-medium
              {{ request()->routeIs('admin.dokumen.*') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
              transition duration-200 ease-in-out">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0113 3.414L16.586 7A2 2 0 0118 8.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
        Semua Dokumen
    </a>

    {{-- Pelaporan SPMI --}}
    <a href="{{ route('admin.pelaporan.index') }}"
       class="flex items-center px-4 py-2 rounded-lg text-base font-medium
              {{ request()->routeIs('admin.pelaporan.*') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
              transition duration-200 ease-in-out">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6zm2 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm0 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1zm0 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
        Pelaporan SPMI
    </a>

    {{-- Audit Mutu Internal (AMI) --}}
    <a href="{{ route('admin.ami.index') }}"
       class="flex items-center px-4 py-2 rounded-lg text-base font-medium
              {{ request()->routeIs('admin.ami.*') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
              transition duration-200 ease-in-out">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Audit Mutu Internal (AMI)
    </a>
    
    {{-- Upload Artikel --}}
    <a href="{{ route('admin.berita.index') }}"
       class="flex items-center px-4 py-2 rounded-lg text-base font-medium
              {{ request()->routeIs('admin.berita.*') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
              transition duration-200 ease-in-out">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm12 3a1 1 0 100 2h-3a1 1 0 100 2h3a1 1 0 100 2H4a1 1 0 100 2h12a1 1 0 100-2H7a1 1 0 100 2h3a1 1 0 100 2H4a1 1 0 100 2h12a1 1 0 100-2H7a1 1 0 100 2h3a1 1 0 100 2h12a1 1 0 100-2H4zm-1-4H5v1a1 1 0 102 0V3z" clip-rule="evenodd"></path></svg>
        Manajemen Berita
    </a>

    {{-- Buat Survey --}}
    <a href="{{ route('admin.survey.index') }}"
       class="flex items-center px-4 py-2 rounded-lg text-base font-medium
              {{ request()->routeIs('admin.survey.*') ? 'bg-blue-500 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}
              transition duration-200 ease-in-out">
        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-12a1 1 0 10-2 0v4a1 1 0 00.293.707L7.5 11.586l.707.707A1 1 0 009 12.586l2.293-2.293A1 1 0 0012.586 9l-.707-.707a1 1 0 00-1.414 0L10 9.586V7a1 1 0 10-2 0z" clip-rule="evenodd"></path></svg>
        Manajemen Survey
    </a>

</nav>

{{-- Logout --}}
<div class="p-4 border-t border-gray-200 mt-auto">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                class="w-full flex items-center justify-center px-4 py-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg font-semibold
                       transition duration-200 ease-in-out transform hover:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
            Keluar
        </button>
    </form>
</div>