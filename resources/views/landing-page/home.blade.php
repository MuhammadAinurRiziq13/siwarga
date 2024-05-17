@extends('landing-page.main')

@section('container')
    <div class="container-main">
        <div class="main-wrapper">
            <div class="Hero">
                <div class="banners">
                    rt 05 rw 01<br />ranuklindungan
                </div>
                <div class="visi-misi">
                    Visi menciptakan lingkungan yang aman, nyaman, tentram, bersih, indah, sehat dan religius.<br />
                    <br />Misi memberikan pelayanan prima kepada warga, mempererat silaturahmi, membina generasi muda,
                    melakukan kebersihan bersama, dan mufakat untuk menciptakan lingkungan yang sejahtera.
                </div>
                <div class="Group15">
                    <button class="contact-us">
                        Contact Us
                    </button>
                </div>
                <div class="container-population justify-content-center align-content-center">
                    <div class="stats-wrapper">
                        <div class="total-residents">
                            <div class="total-residents-content">
                                <div class="total-residents-number">2300</div>
                                <div class="total-residents-label">jumlah warga</div>
                            </div>
                        </div>
                        <div class="other-stats">
                            <div class="other-stats-wrapper">
                                <div class="total-families">
                                    <div class="total-families-content">
                                        <div class="total-families-number">40</div>
                                        <div class="total-families-label">Jumlah keluarga</div>
                                    </div>
                                </div>
                                <div class="total-families">
                                    <div class="total-families-content">
                                        <div class="total-families-number">40</div>
                                        <div class="total-families-label">Jumlah keluarga</div>
                                    </div>
                                </div>
                                <div class="total-families">
                                    <div class="total-families-content">
                                        <div class="total-families-number">40</div>
                                        <div class="total-families-label">Jumlah keluarga</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="description-section">
        <h2 class="section-title">DESKRIPSI</h2>
        <div class="title-divider"></div>
        <div class="content-wrapper">
            <div class="content-container">
                <div class="image-column">
                    <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/a3e6d17b641e34ad30979549fa33547688e932b606f87337b077bf8d50dab153?apiKey=cfbeda57ea98489b824f8f843623dee9&"
                        alt="Description image" class="description-image" loading="lazy" />
                </div>
                <div class="text-column">
                    <div class="description-text">
                        <p class="description-paragraph">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Turpis in eu mi bibendum neque egestas
                            congue quisque egestas. Bibendum ut tristique et egestas quis ipsum suspendisse
                            ultrices. Magnis dis parturient montes nascetur ridiculus mus. Egestas pretium aenean
                            pharetra magna ac. Aliquam malesuada bibendum arcu vitae. Purus in mollis nunc sed id.
                            Vel fringilla est ullamcorper eget nulla facilisi etiam. Mattis vulputate enim nulla
                            aliquet. Nibh cras pulvinar mattis nunc sed. Vitae et leo duis ut.
                            <br />
                            Ipsum dolor sit amet consectetur adipiscing elit. Arcu ac tortor dignissim convallis
                            aenean et tortor at risus. Eget est lorem ipsum dolor sit amet consectetur adipiscing.
                            Maecenas pharetra convallis posuere morbi leo urna molestie at. Laoreet suspendisse
                            interdum consectetur libero id faucibus.
                        </p>
                        <div class="facilities-list">
                            <ul class="facilities-column">
                                <li class="facility-name">PKK</li>
                                <li class="facility-name">PKK</li>
                                <li class="facility-name">PKK</li>
                            </ul>
                            <ul class="facilities-column">
                                <li class="facility-name">PKK</li>
                                <li class="facility-name">PKK</li>
                                <li class="facility-name">PKK</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    /*style description*/
    .description-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0 20px;
    }

    .section-title {
        color: #000;
        letter-spacing: 4.2px;
        text-transform: uppercase;
        font: 900 60px Poppins, sans-serif;
    }

    @media (max-width: 991px) {
        .section-title {
            font-size: 40px;
        }
    }

    .title-divider {
        border: 1px solid #000;
        background-color: #000;
        margin-top: 23px;
        width: 800px;
        max-width: 100%;
    }

    .content-wrapper {
        align-self: stretch;
        margin-top: 32px;
        width: 100%;
    }

    @media (max-width: 991px) {
        .content-wrapper {
            max-width: 100%;
        }
    }

    .content-container {
        display: flex;
        gap: 20px;
    }

    @media (max-width: 991px) {
        .content-container {
            flex-direction: column;
            align-items: stretch;
            gap: 0;
        }
    }

    .image-column {
        display: flex;
        flex-direction: column;
        line-height: normal;
        width: 44%;
        margin-left: 0;
    }

    @media (max-width: 991px) {
        .image-column {
            width: 100%;
        }
    }

    .description-image {
        aspect-ratio: 1.01;
        object-fit: auto;
        object-position: center;
        width: 100%;
        flex-grow: 1;
    }

    @media (max-width: 991px) {
        .description-image {
            max-width: 100%;
            margin-top: 40px;
        }
    }

    .text-column {
        display: flex;
        flex-direction: column;
        line-height: normal;
        width: 56%;
        margin-left: 20px;
    }

    @media (max-width: 991px) {
        .text-column {
            width: 100%;
        }
    }

    .description-text {
        display: flex;
        flex-direction: column;
        align-self: stretch;
        color: #000;
        margin: auto 0;
    }

    @media (max-width: 991px) {
        .description-text {
            max-width: 100%;
            margin-top: 40px;
        }
    }

    .description-paragraph {
        font: 400 17px Poppins, sans-serif;
    }

    @media (max-width: 991px) {
        .description-paragraph {
            max-width: 100%;
        }
    }

    .facilities-list {
        display: flex;
        margin-top: 116px;
        gap: 20px;
    }

    @media (max-width: 991px) {
        .facilities-list {
            max-width: 100%;
            flex-wrap: wrap;
            padding-right: 20px;
            margin-top: 40px;
        }
    }

    .facilities-column {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .facility-item {
        display: flex;
        gap: 20px;
        white-space: nowrap;
    }

    @media (max-width: 991px) {
        .facility-item {
            white-space: initial;
        }
    }

    .facility-icon {
        font: 900 20px "Font Awesome 5 Free", -apple-system, Roboto, Helvetica, sans-serif;
    }

    .facility-name {
        flex-grow: 1;
        flex-basis: auto;
        margin: auto 0;
        font: 400 17px Poppins, sans-serif;
    }

    /*Style main*/
    .container-main {
        height: 1000px;
        background:
            linear-gradient(251deg,
                #FAFFE5 10%,
                rgba(169, 253, 205, 0.55) 38%,
                rgba(171, 222, 129, 0.20) 72%,
                rgba(254, 253, 248, 0.60) 100%),
                linear-gradient(180deg,
                rgba(255, 255, 255, 0) 60%, white 100%);

    }

    .main-wrapper {
        padding: 40px;
        margin: 20px auto;
        max-width: 1200px;
        font-family: Poppins, sans-serif;
    }

    .Hero {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
        position: relative;
        width: 100%;
        height: 100%;
    }

    .banners {
        color: black;
        font-size: 55px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3.85px;
        word-wrap: break-word;
        width: 65%;
    }

    .visi-misi {
        color: #6D6E6C;
        font-size: 17px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.19px;
        word-wrap: break-word;
        width: 60%;
    }

    .Group15 {
        width: 100%;
        display: flex;
        justify-content: flex-start;
    }

    .contact-us {
        width: 231.32px;
        height: 73px;
        background: #4DC969;
        border-radius: 9px;
        text-transform: uppercase;
        color: white;
        border: none;
    }

    .content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px;
    }

    /* style population*/
    .container-population {
        border-radius: 20px;
        background-color: rgba(0, 0, 0, 0.1);
        padding: 20px 35px;
        justify-content: center;
        align-content: center;
    }

    .stats-wrapper {
        display: flex;
        gap: 20px;
    }

    .total-residents {
        display: flex;
        flex-direction: column;
        width: 36%;
    }

    .total-residents-content {
        display: flex;
        flex-direction: column;
        align-self: stretch;
        color: #050505;
        text-align: center;
        margin: auto 0;
    }

    .total-residents-number {
        align-self: center;
        font: 700 55px Poppins, sans-serif;
    }

    .total-residents-label {
        letter-spacing: 2.1px;
        text-transform: uppercase;
        font: 900 30px/143% Poppins, sans-serif;
    }

    .other-stats {
        display: flex;
        flex-direction: column;
        width: 60%;
        margin-left: 20px;
    }

    .other-stats-wrapper {
        display: flex;
        gap: 20px;
    }

    .total-families {
        display: flex;
        flex-direction: column;
        width: 33%;
    }

    .total-families-content {
        display: flex;
        flex-direction: column;
        color: #050505;
        text-align: center;
    }

    .total-families-number {
        align-self: center;
        font: 700 55px Poppins, sans-serif;
    }

    .total-families-label {
        letter-spacing: 1.4px;
        text-transform: uppercase;
        font: 500 20px/43px Poppins, sans-serif;
    }
</style>
