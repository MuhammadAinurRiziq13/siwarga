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

                <div class="row g-4 d-flex justify-content-center">
                    @if ($landingPage->gallery->isEmpty())
                        <p>No Gallery items found.</p>
                    @else
                        @foreach ($landingPage->gallery as $item)
                            <div class="col-lg-3">
                                <div class="post-box">
                                    <div class="post-img"><img src="{{ asset('storage/' . $item->nama_foto) }}" class="img-fluid"
                                            alt=""></div>
                                    <span class="post-date">{{ $item->tanggal_kegiatan }}</span>
                                    <h3 class="post-title">{{ $item->judul }}</h3>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    {{-- <div class="col-lg-3">
                        <div class="post-box">
                            <div class="post-img"><img src="assets/img/blog/asman-toga.jpg" class="img-fluid"
                                    alt=""></div>
                            <span class="post-date">Tue, September 15</span>
                            <h3 class="post-title">Penyerahan Penghargaan Juara 1 Lomba Asuhan Mandiri Toga yang Dihadiri
                                Langsung
                                oleh Ibu Bupati Pasuruan</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="post-box">
                            <div class="post-img"><img src="assets/img/blog/kerja-bakti.jpg" class="img-fluid"
                                    alt=""></div>
                            <span class="post-date">Fri, August 28</span>
                            <h3 class="post-title">Kerja Bakti Pengecatan Gang dalam Rangka HUT Kemerdekaan RI</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="post-box">
                            <div class="post-img"><img src="assets/img/blog/tasyakuran-kemerdekaan.jpg" class="img-fluid"
                                    alt="">
                            </div>
                            <span class="post-date">Mon, July 11</span>
                            <h3 class="post-title">Kegiatan Rutinan Malam Tasyakuran dalam Rangka HUT Kemerdekaan RI</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="post-box">
                            <div class="post-img"><img src="assets/img/blog/santunan.jpg" class="img-fluid"
                                    alt=""></div>
                            <span class="post-date">Mon, July 11</span>
                            <h3 class="post-title">Kegiatan Santunan untuk Anak Yatim Piatu</h3>
                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="post-box">
                            <div class="post-img"><img src="assets/img/blog/suroan.jpg" class="img-fluid"
                                    alt=""></div>
                            <span class="post-date">Mon, July 11</span>
                            <h3 class="post-title">Peringatan Malam 1 Suro atau 1 Muharram</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="post-box">
                            <div class="post-img"><img src="assets/img/blog/pemuda-peduli.jpg" class="img-fluid"
                                    alt=""></div>
                            <span class="post-date">Mon, July 11</span>
                            <h3 class="post-title">Kegiatan Pemuda Peduli pada Bulan Ramadhan</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="post-box">
                            <div class="post-img"><img src="assets/img/blog/pavingisasi.jpg" class="img-fluid"
                                    alt=""></div>
                            <span class="post-date">Mon, July 11</span>
                            <h3 class="post-title">Kerja Bakti Pavingisasi Desa yang Dilaksanakan di RT 05</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="post-box">
                            <div class="post-img"><img src="assets/img/blog/asman.jpg" class="img-fluid" alt="">
                            </div>
                            <span class="post-date">Mon, July 11</span>
                            <h3 class="post-title">Peresmian Taman Toga RT 05</h3>
                        </div>
                    </div> --}}

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
                                        Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet
                                        non curabitur
                                        gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
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
                                        Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum
                                        velit laoreet id
                                        donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est
                                        pellentesque
                                        elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt
                                        dui.
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
                                        Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in
                                        est ante in.
                                        Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing
                                        bibendum est.
                                        Purus gravida quis blandit turpis cursus in.
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
                                        Kami selalu terbuka untuk menerima masukan dan saran dari pengguna SIWarga. Anda
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
                                    <p>samlalala@gmail,com<br>yeah@gmail.com</p>
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
                        <form action="forms/contact.php" method="post" class="php-email-form">
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
                                    <div class="sent-message">Your message has been sent. Thank you!</div>

                                    <button type="submit">Send Message</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

        </section>
        <!-- End Contact Section -->

    </main>
@endsection
