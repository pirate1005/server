@extends('layouts.admin')

@section('title', 'Tentang Kami')

@section('content')

    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">Kelola Halaman Tentang Kami</h2>
        <p class="text-gray-400 text-sm">Update informasi perusahaan/website yang akan dilihat oleh pengguna.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 text-green-500 rounded-xl">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/50 text-red-500 rounded-xl">
            <ul class="list-disc list-inside text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-[#141625] border border-gray-800 rounded-2xl p-6 lg:p-8 max-w-4xl shadow-xl">
        <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="text-sm font-bold text-gray-400 mb-2 block uppercase tracking-wider">Judul Halaman</label>
                <input type="text" name="title" value="{{ old('title', $about->title ?? 'Tentang Kami') }}" required 
                    class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition">
            </div>

            <div class="mb-6">
                <label class="text-sm font-bold text-gray-400 mb-2 block uppercase tracking-wider">Banner / Gambar (Opsional)</label>
                
                @if(isset($about) && $about->image_path)
                    <div class="mb-3">
                        <img src="{{ asset($about->image_path) }}" class="h-40 w-auto rounded-xl border border-gray-700 object-cover shadow-lg">
                    </div>
                @endif
                
                <input type="file" name="image" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-500/10 file:text-cyan-400 hover:file:bg-cyan-500/20 border border-gray-700 rounded-xl transition cursor-pointer">
                <p class="text-[10px] text-gray-500 mt-2">*Abaikan jika tidak ingin mengubah gambar.</p>
            </div>

            <div class="mb-8">
                <label class="text-sm font-bold text-gray-400 mb-2 block uppercase tracking-wider">Isi Deskripsi Tentang Kami</label>
                <textarea name="content" rows="10" required placeholder="Tuliskan latar belakang, visi, misi perusahaan di sini..."
                    class="w-full bg-[#0B0C15] border border-gray-700 rounded-xl px-4 py-3 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none transition leading-relaxed">{{ old('content', $about->content ?? '') }}</textarea>
                <p class="text-[10px] text-gray-500 mt-2">*Anda bisa menggunakan spasi dan enter. Teks akan menyesuaikan format paragraf.</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-8 py-3 bg-cyan-600 hover:bg-cyan-500 text-white font-bold rounded-xl transition shadow-lg shadow-cyan-900/20 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

@endsection