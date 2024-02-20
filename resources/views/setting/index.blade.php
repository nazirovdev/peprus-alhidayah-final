@extends('layout.index')
@section('content')
    <div class="section-header">
        <h1>Pengaturan</h1>
    </div>
    <div class="row">
        <div class="col-12">
            @if (Session::get('status'))
                <div class="alert alert-dismissible show fade" style="background-color: #22c55e!important;">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        {{ Session::get('status') }}
                    </div>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-md">
                    <tbody>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Max Hari Peminjaman</th>
                            {{-- <th class="text-center">Perpanjangan Hari</th> --}}
                            <th class="text-center">Denda</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                        @forelse ($settings as $setting)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $setting->max_hari_pinjam }}</td>
                                {{-- <td class="text-center">{{ $setting->perpanjangan_hari }}</td> --}}
                                <td class="text-center">{{ $setting->denda }}</td>
                                <td class="text-center">
                                    <a href="/pengaturan/{{ $setting->id }}" class="btn btn-warning">
                                        <i>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-edit" width="18" height="18"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                <path
                                                    d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                <path d="M16 5l3 3" />
                                            </svg>
                                        </i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <td colspan="5" class="text-center" style="font-weight: bold">Data Masih Kosong</td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
