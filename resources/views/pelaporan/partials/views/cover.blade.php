<title>COVER</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        padding: 0;
        margin: 0;
        border: 1px solid #000;
        position: relative;
    }

    header {
        position: relative;
        top: 60px;
        text-align: center;
    }

    footer {
        position: absolute;
        bottom: 0px;
        width: 100%;
        border-top: 1px solid #000;
    }
</style>

<body>

    <header>
        <h1 style="margin: 0px;">{{ strtoupper($judul) }}</h1>
        <div style="margin: 0px; font-size: 24px;">{{ strtoupper($sub_judul) }}</div>
    </header>

    <table width="100%" style="height: 50em;">
        <tr>
            <td align="center" valign="middle">
                <img src="data:image/png;base64,{{ $logo }}" width="290" alt="Logo">
            </td>
        </tr>
    </table>

    <footer>
        <table width="100%">
            <tr>
                <td align="center">
                    <div>{{ strtoupper($nama) }}</div>
                    <div>
                        <b>{{ strtoupper($alamat) }}</b>
                    </div>
                    <div style="font-size: 10px; color: grey;">
                        <i>{{ $nomor_usaha }}</i>
                    </div>
                    <div style="font-size: 10px; color: grey;">
                        <i>{{ $info }}</i>
                    </div>
                    <div style="font-size: 10px; color: grey;">
                        <i>{{ $email }}</i>
                    </div>
                    <div style="font-size: 10px; color: grey; margin-top: 10px;">
                        <i>Tahun {{ $tahun }}</i>
                    </div>
                </td>
            </tr>
        </table>
    </footer>
</body>
