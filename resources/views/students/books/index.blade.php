@extends('students.layout.index')
@section('content')
    <div class="section-header">
        <h1>Daftar Buku Siswa</h1>
    </div>

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

    <div class="row">
        @forelse ($books as $book)
            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                <article
                    style="height: auto; box-shadow: 1px 1px 1px rgba(0, 0, 0, 0.1);overflow: hidden; border-radius: 10px; margin-bottom: 10px">
                    <div style="width: 100%; height: auto; background-color: red">
                        <img src="{{ $book->image == null ? asset('assets/images/default.jpg') : asset('storage/buku/' . $book->image) }}"
                            alt="" style="display: block; width: 100%; height: 100%; object-fit: cover">
                    </div>
                    <div style="display: flex; justify-content: space-between; flex-direction: column; padding: 10px">
                        <div style="height: auto; display: flex; justify-content: center; align-items: center">
                            <h4 style="font-size: 18px; text-align: center">{{ $book->judul }}</h4>
                        </div>
                        <div
                            style="height: auto; display: flex; justify-content: center; align-items: center; flex-wrap: wrap; gap: 5px">
                            @if ($book->status == 'dipinjam')
                                <a href="#" class="btn btn-sm btn-danger"
                                    style="height: fit-content; height: 30px;">Sedang dipinjam</a>
                            @else
                                <a href="/dashboard/siswa/buku/pinjam/{{ $book->id }}" class="btn btn-sm btn-success"
                                    style="height: fit-content; width: 80px; height: 30px;">Pinjam</a>
                            @endif
                            {{-- @if ($book->cart->where('student_id', Auth::guard('student')->id())->first()->student_id ?? '')
                                <button book-id="{{ $book->id }}" class="btn btn-sm cart-btn"
                                    style="height: fit-content; width: 80px; height: 30px; background-color: #0284c7; color: white">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-shopping-cart-filled" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M6 2a1 1 0 0 1 .993 .883l.007 .117v1.068l13.071 .935a1 1 0 0 1 .929 1.024l-.01 .114l-1 7a1 1 0 0 1 -.877 .853l-.113 .006h-12v2h10a3 3 0 1 1 -2.995 3.176l-.005 -.176l.005 -.176c.017 -.288 .074 -.564 .166 -.824h-5.342a3 3 0 1 1 -5.824 1.176l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-12.17h-1a1 1 0 0 1 -.993 -.883l-.007 -.117a1 1 0 0 1 .883 -.993l.117 -.007h2zm0 16a1 1 0 1 0 0 2a1 1 0 0 0 0 -2zm11 0a1 1 0 1 0 0 2a1 1 0 0 0 0 -2z"
                                                stroke-width="0" fill="currentColor" />
                                        </svg>
                                    </i>
                                </button>
                            @else
                                <button book-id="{{ $book->id }}" class="btn btn-sm cart-btn"
                                    style="height: fit-content; width: 80px; height: 30px; background-color: #0284c7; color: white">
                                    <i>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-shopping-cart" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                            <path d="M17 17h-11v-14h-2" />
                                            <path d="M6 5l14 1l-1 7h-13" />
                                        </svg>
                                    </i>
                                </button>
                            @endif --}}
                        </div>
                    </div>
                </article>
            </div>
        @empty
            <h3>Buku tidak tersedia</h3>
        @endforelse
    </div>
    <script></script>
@endsection
