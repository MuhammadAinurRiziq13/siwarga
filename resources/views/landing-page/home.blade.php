@extends('landing-page.main')

@section('hero')
    <section id="hero" class="hero d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center">
                    <h1 data-aos="fade-up" class="mb-3">RT 05 RW 01 RANUKLINDUNGAN</h1>
                    <h6 data-aos="fade-up" data-aos-delay="400">Visi menciptakan lingkungan yang aman, nyaman, tentram,
                        bersih,
                        indah, sehat dan religius.</h6>
                    <h6 data-aos="fade-up" data-aos-delay="400">Misi memberikan pelayanan prima kepada warga, mempererat
                        silaturahmi, membina generasi muda, melakukan kebersihan bersama, dan mufakat untuk menciptakan
                        lingkungan
                        yang sejahtera.</h6>
                    <div data-aos="fade-up" data-aos-delay="600">
                        <div class="text-center text-lg-start">
                            <a href="#contact"
                                class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                                <span>Contact Us</span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
                    <img src="{{ asset('img/landing-page/hero-img-green.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </section>
@endsection

@section('main')
    <main id="main">

        <!-- ======= Counts Data Warga Section ======= -->
        <section id="counts" class="counts">
            <div class="container" data-aos="fade-up">
                <header class="section-header mb-5">
                    <p class="border-bottom border-2 pb-4 px-5 d-inline">Data Warga</p>
                </header>
                <div class="row g-1">

                    <div class="col-lg-4 col-md-2">
                        <div class="count-box warga">
                            <div class="text-center">
                                <span data-purecounter-start="0" data-purecounter-end="{{ $landingPage->resident }}"
                                    data-purecounter-duration="2" class="purecounter"></span>
                                <p>Jumlah Warga</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <div class="count-box">
                            <div class="text-center">
                                <span data-purecounter-start="0" data-purecounter-end="{{ $landingPage->family }}"
                                    data-purecounter-duration="2" class="purecounter"></span>
                                <p>Jumlah Keluarga</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <div class="count-box">
                            <div class="text-center">
                                <span data-purecounter-start="0" data-purecounter-end="{{ $landingPage->temporary }}"
                                    data-purecounter-duration="2" class="purecounter"></span>
                                <p>Warga Sementara</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <div class="count-box">
                            <div class="text-center">
                                <span data-purecounter-start="0" data-purecounter-end="{{ $landingPage->elder }}"
                                    data-purecounter-duration="2" class="purecounter"></span>
                                <p>Jumlah Lansia</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2">
                        <div class="count-box">
                            <div class="text-center">
                                <span data-purecounter-start="0" data-purecounter-end="{{ $landingPage->toddlers }}"
                                    data-purecounter-duration="2" class="purecounter"></span>
                                <p>Jumlah Balita</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Counts Data Warga Section -->

        <!-- ======= About Section ======= -->
        <section id="about" class="about">

            <div class="container" data-aos="fade-up">
                <header class="section-header mb-5">
                    <p class="border-bottom border-2 pb-4 px-5 d-inline">Deskripsi</p>
                </header>
                <div class="row gx-0">

                    <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                        <img src="{{ asset('img/landing-page/wayang.jpg') }}" class="img-fluid" alt="">
                    </div>

                    <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                        <div class="content">
                            <!-- <h2>Expedita voluptas omnis cupiditate totam eveniet nobis sint iste. Dolores est repellat corrupti reprehenderit.</h2> -->
                            <p>
                                RT 05 RW 01, yang terletak di Dusun Bandilan, Desa Ranuklindungan, Kecamatan Grati,
                                Kabupaten Pasuruan,
                                adalah sebuah lingkungan yang hidup dan harmonis. Di bawah kepemimpinan Bapak Saikhul Anwar
                                Murwantoro,
                                RT ini telah menjadi contoh nyata semangat gotong royong dan prestasi gemilang.
                            </p>
                            <p>
                                Salah satu pencapaian membanggakan dari RT 05 adalah keberhasilannya dalam Lomba Asuhan
                                Mandiri Toga
                                mewakili Desa Ranuklindungan.
                                Berkat dedikasi dan kerja keras seluruh warga, RT ini berhasil meraih juara 1 tingkat
                                kabupaten dan
                                juara 3 tingkat provinsi. Prestasi ini tidak hanya mengharumkan nama RT 05, tetapi juga
                                menjadi
                                inspirasi bagi lingkungan lainnya.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </section>
        <!-- End About Section -->

        <!-- ======= Galeri Section ======= -->
        <section id="recent-blog-posts" class="recent-blog-posts">

            <div class="container" data-aos="fade-up">

                <header class="section-header mb-5">
                    <p class="border-bottom border-2 pb-4 px-5 d-inline">Galeri</p>
                </header>

                {{-- <div class="row g-4 d-flex justify-content-center">
                    @if ($landingPage->gallery->isEmpty())
                        <p>No Gallery items found.</p>
                    @else
                        @foreach ($landingPage->gallery as $item)
                            <div class="col-lg-3">
                                <div class="post-box">
                                    <div class="post-img"><img src="{{ asset('storage/' . $item->nama_foto) }}"
                                            class="img-fluid" alt=""></div>
                                    <span class="post-date">{{ $item->tanggal_kegiatan }}</span>
                                    <h3 class="post-title">{{ $item->judul }}</h3>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div> --}}

                <div id="gallery-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        @if ($landingPage->gallery->isEmpty())
                            <p-No Gallery items found.</p>
                            @else
                                @foreach ($landingPage->gallery->chunk(8) as $chunk)
                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                        <div class="row g-4 d-flex justify-content-center">
                                            @foreach ($chunk as $item)
                                                <div class="col-lg-3">
                                                    <div class="post-box">
                                                        <div class="post-img"><img
                                                                src="{{ asset('storage/' . $item->nama_foto) }}"
                                                                class="img-fluid" alt=""></div>
                                                        <span class="post-date">{{ date('d-m-Y', strtotime($item->tanggal_kegiatan)) }}</span>
                                                        <h3 class="post-title">{{ $item->judul }}</h3>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                        @endif
                    </div>
                    <a class="carousel-control-prev bg-dark text-white" href="#gallery-carousel" role="button"
                        data-bs-target="#gallery-carousel" data-bs-slide="prev">
                        <span aria-hidden="true">&lsaquo;</span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next bg-dark text-white" href="#gallery-carousel" role="button"
                        data-bs-target="#gallery-carousel" data-bs-slide="next">
                        <span aria-hidden="true">&rsaquo;</span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

            </div>

        </section>
        <!-- End Galeri Section -->

        <!-- ======= F.A.Q Section ======= -->
        <section id="faq" class="faq">

            <div class="container" data-aos="fade-up">

                <header class="section-header mb-5">
                    <p class="border-bottom border-2 pb-4 px-5 d-inline">Frequently Asked Questions</p>
                </header>

                <div class="row">
                    <div class="col-lg-6">
                        <!-- F.A.Q List 1-->
                        <div class="accordion accordion-flush" id="faqlist1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-content-1">
                                        Bagaimana cara saya mengajukan perubahan data?
                                    </button>
                                </h2>
                                <div id="faq-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Buka aplikasi/situs web dan masukkan username dan password Anda untuk login.</li>
                                            <li>Setelah login, pilih menu "Edit Data Warga" dari menu utama.</li>
                                            <li>Cari data warga yang ingin Anda ubah.Klik tombol yang berwarna kuning pada data warga yang ingin Anda ubah.</li>
                                            <li>Masukkan perubahan data yang Anda inginkan pada formulir yang disediakan. Pastikan semua data yang diubah sudah benar.</li>
                                            <li>Setelah selesai mengubah data, klik tombol "Kirim" untuk menyimpan perubahan.</li>
                                            <li>Data yang diubah akan diproses oleh admin. Tunggu hingga admin selesai memverifikasi data Anda.</li>
                                            <li>Anda akan menerima notifikasi melalui email atau SMS setelah data Anda diubah oleh admin.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq-content-2">
                                        Bagaimana cara saya mengajukan surat pengantar?
                                    </button>
                                </h2>
                                <div id="faq-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist1">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Buka aplikasi/situs web dan masukkan username dan password Anda untuk login.</li>
                                            <li>Setelah login, pilih menu "Surat pengantar" dari menu utama.</li>
                                            <li>Klik tombol "tambah" yang terletak di kanan atas.</li>
                                            <li>Anda akan diarahkan ke halaman pengisian formulir surat pengajuan. Isi semua data yang diperlukan dengan lengkap dan benar, seperti nama, no.Hp dan keperluan.</li>
                                            <li>Setelah selesai mengisi formulir, klik tombol "Kirim" untuk mengirim surat pengantar.</li>
                                            <li>Surat pengantar akan diproses oleh admin. Tunggu hingga admin selesai memverifikasi data Anda.</li>
                                            <li>Anda akan menerima notifikasi melalui email atau SMS setelah surat pengantar Anda diterima oleh admin.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6">

                        <!-- F.A.Q List 2-->
                        <div class="accordion accordion-flush" id="faqlist2">

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq2-content-1">
                                        Bagaimana cara saya mendaftarkan keluarga prasaejahtera?
                                    </button>
                                </h2>
                                <div id="faq2-content-1" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        <ol>
                                            <li>Buka aplikasi/situs web dan masukkan username dan password Anda untuk login.</li>
                                            <li>Setelah login, pilih menu "Keluarga Seahtera" dari menu utama.</li>
                                            <li>Klik tombol "tambah" yang terletak di kanan atas.</li>
                                            <li>Anda akan diarahkan ke halaman pengisian formulir Pengajuan Keluarga Pra Sejahtera. Isi semua data yang diperlukan dengan lengkap dan benar, seperti pendapatan, jumlah tanggungan dan no.Hp.</li>
                                            <li>Jangan lupa untuk melampirkan foto bukti sebagai bahan pertimbangan admin.</li>
                                            <li>Setelah selesai mengisi formulir, klik tombol "Kirim" untuk mengirim surat Pengajuan Keluarga Pra Sejahtera.</li>
                                            <li>Surat Pengajuan Keluarga Pra Sejahtera akan diproses oleh admin. Tunggu hingga admin selesai memverifikasi data Anda.</li>
                                            <li>Anda akan menerima notifikasi melalui email atau SMS setelah surat Pengajuan Keluarga Pra Sejahtera Anda diterima oleh admin.</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#faq2-content-2">
                                        Bagaimana cara memberi masukan atau saran untuk website ini?
                                    </button>
                                </h2>
                                <div id="faq2-content-2" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                                    <div class="accordion-body">
                                        Kami selalu terbuka untuk menerima masukan dan saran dari pengguna PORT-05. Anda
                                        dapat memberikan
                                        masukan atau saran melalui email ke di bagian Contact Us di bawah.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </section>
        <!-- End F.A.Q Section -->

        <!-- ======= Team Section ======= -->
        <section id="testimonials" class="testimonials">
            <div class="container" data-aos="fade-up">
                <header class="section-header mb-5">
                    <p class="border-bottom border-2 pb-4 px-5 d-inline">Our Team</p>
                </header>

                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="200">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="profile mt-auto mb-3">
                                    <img src="{{ asset('img/landing-page/team/elis.jpg') }}" class="testimonial-img"
                                        alt="">
                                    <h3>Elis Nurhidayati</h3>
                                    <h4>Documentator</h4>
                                </div>
                                <p>
                                    Teliti dalam mendokumentasikan setiap langkah proyek, memastikan informasi tersampaikan
                                    dengan jelas
                                    dan akurat. Kemampuannya dalam merangkum dan menyusun laporan sangat berharga bagi tim.
                                </p>
                                <div class="social-links mt-3">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="profile mt-auto mb-3">
                                    <img src="{{ asset('img/landing-page/team/rama.jpg') }}" class="testimonial-img"
                                        alt="">
                                    <h3>Rama Pramudhita Bhaskara</h3>
                                    <h4>Project Lead</h4>
                                </div>
                                <p>
                                    Pemimpin yang menginspirasi, mampu mengarahkan tim dengan visi yang jelas. Keahliannya
                                    dalam manajemen
                                    proyek dan komunikasi memastikan proyek berjalan lancar dan mencapai tujuan.
                                </p>
                                <div class="social-links mt-3">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="profile mt-auto mb-3">
                                    <img src="{{ asset('img/landing-page/team/riziq.jpg') }}" class="testimonial-img"
                                        alt="">
                                    <h3>Muhammad Ainur Riziq</h3>
                                    <h4>Programmer</h4>
                                </div>
                                <p>
                                    Programmer handal dengan pemahaman mendalam tentang bahasa pemrograman. Kreativitas dan
                                    kemampuan
                                    problem-solvingnya menghasilkan kode yang efisien dan solusi inovatif.
                                </p>
                                <div class="social-links mt-3">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="profile mt-auto mb-3">
                                    <img src="{{ asset('img/landing-page/team/alham.jpg') }}" class="testimonial-img"
                                        alt="">
                                    <h3>Alhamdana Fariz Alfurqaan</h3>
                                    <h4>UI/UX Designer</h4>
                                </div>
                                <p>
                                    Desainer berbakat dengan fokus pada pengalaman pengguna. Rancangannya intuitif, menarik,
                                    dan
                                    fungsional, meningkatkan interaksi pengguna dengan produk.
                                </p>
                                <div class="social-links mt-3">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <div class="profile mt-auto mb-3">
                                    <img src="{{ asset('img/landing-page/team/mahi.jpg') }}" class="testimonial-img"
                                        alt="">
                                    <h3>Mochammad Nizar Mahi</h3>
                                    <h4>Tester</h4>
                                </div>
                                <p>
                                    Tester yang cermat dan teliti, memastikan kualitas produk dengan mengidentifikasi dan
                                    melaporkan bug
                                    secara efektif. Kontribusinya sangat penting dalam menghadirkan produk yang handal.
                                </p>
                                <div class="social-links mt-3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-pagination"></div>
                </div>

            </div>

        </section>
        <!-- End Team Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">

            <div class="container" data-aos="fade-up">
                <header class="section-header mb-5">
                    <p class="border-bottom border-2 pb-4 px-5 d-inline">Contact Us</p>
                </header>

                <div class="row gy-4">
                    <div class="col-lg-4">
                        <div class="row gy-4">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d475.34971782036905!2d113.01021872035986!3d-7.720556832232463!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7b737529d3865%3A0x90d0ba4b8400509!2sRumah%20tinggal!5e0!3m2!1sid!2sid!4v1717114928364!5m2!1sid!2sid"
                                width="400" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div class="row gy-4">
                            <div class="col-md-12">
                                <div class="info-box">
                                    <i class="bi bi-envelope"></i>
                                    <h3>Email Us</h3>
                                    <p>051.port.2024@gmail.com
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="info-box">
                                    <i class="bi bi-clock"></i>
                                    <h3>Open Hours</h3>
                                    <p>Monday - Sunday<br>9:00AM - 22:00PM</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <form action="{{ asset('forms/send-mail.php') }}" method="post" class="php-email-form">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                        required>
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message"></div>

                                    <button type="submit" class="submit">Send Message</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

        </section>
        <!-- End Contact Section -->

    </main>
@endsection

@push('js')
    <script>
        document.querySelector('.php-email-form').addEventListener('submit', function(e) {
            e.preventDefault();

            var form = e.target;
            var formData = new FormData(form);
            var submitButton = form.querySelector('button[type="submit"]');
            var errorMessage = document.querySelector('.error-message');
            var sentMessage = document.querySelector('.sent-message');

            // Hide submit button
            submitButton.style.display = 'none';

            var xhr = new XMLHttpRequest();
            xhr.open('POST', form.action, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.status === 'success') {
                        sentMessage.style.display = 'block';
                        sentMessage.textContent = response.message;
                        errorMessage.style.display = 'none';
                        errorMessage.classList.remove('d-block');

                        // Hide messages after 5 seconds
                        setTimeout(function() {
                            $(sentMessage).fadeOut();
                            errorMessage.classList.remove('d-block');
                            submitButton.style.display = 'inline-block';
                        }, 5000);
                    } else {
                        errorMessage.style.display = 'block';
                        errorMessage.textContent = response.message;
                        sentMessage.classList.remove('d-block');

                        // Hide messages after 5 seconds
                        setTimeout(function() {
                            $(errorMessage).fadeOut();
                            submitButton.style.display = 'inline-block';
                        }, 5000);
                    }
                }
            };
            xhr.send(formData);
        });
    </script>
@endpush
