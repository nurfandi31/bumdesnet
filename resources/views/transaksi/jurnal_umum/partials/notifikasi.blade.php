 @php
     use App\Utils\Tanggal;

     $kuitansi = false;
     $files = 'bm';
     if (
         $keuangan->startWith($trx->rekening_debit, '1.1.01') &&
         !$keuangan->startWith($trx->rekening_kredit, '1.1.01')
     ) {
         $files = 'bkm';
         $kuitansi = true;
     }
     if (
         !$keuangan->startWith($trx->rekening_debit, '1.1.01') &&
         $keuangan->startWith($trx->rekening_kredit, '1.1.01')
     ) {
         $files = 'bkk';
         $kuitansi = true;
     }
     if (
         $keuangan->startWith($trx->rekening_debit, '1.1.01') &&
         $keuangan->startWith($trx->rekening_kredit, '1.1.01')
     ) {
         $files = 'bm';
         $kuitansi = false;
     }
     if (
         $keuangan->startWith($trx->rekening_debit, '1.1.02') &&
         !(
             $keuangan->startWith($trx->rekening_kredit, '1.1.01') ||
             $keuangan->startWith($trx->rekening_kredit, '1.1.02')
         )
     ) {
         $files = 'bkm';
         $kuitansi = true;
     }
     if (
         $keuangan->startWith($trx->rekening_debit, '1.1.02') &&
         $keuangan->startWith($trx->rekening_kredit, '1.1.02')
     ) {
         $files = 'bm';
         $kuitansi = false;
     }
     if (
         $keuangan->startWith($trx->rekening_debit, '1.1.02') &&
         $keuangan->startWith($trx->rekening_kredit, '1.1.01')
     ) {
         $files = 'bm';
         $kuitansi = false;
     }
     if (
         $keuangan->startWith($trx->rekening_debit, '1.1.01') &&
         $keuangan->startWith($trx->rekening_kredit, '1.1.02')
     ) {
         $files = 'bm';
         $kuitansi = false;
     }
     if (
         $keuangan->startWith($trx->rekening_debit, '5.') &&
         !(
             $keuangan->startWith($trx->rekening_kredit, '1.1.01') ||
             $keuangan->startWith($trx->rekening_kredit, '1.1.02')
         )
     ) {
         $files = 'bm';
         $kuitansi = false;
     }
     if (
         !(
             $keuangan->startWith($trx->rekening_debit, '1.1.01') ||
             $keuangan->startWith($trx->rekening_debit, '1.1.02')
         ) &&
         $keuangan->startWith($trx->rekening_kredit, '1.1.02')
     ) {
         $files = 'bm';
         $kuitansi = false;
     }
     if (
         !(
             $keuangan->startWith($trx->rekening_debit, '1.1.01') ||
             $keuangan->startWith($trx->rekening_debit, '1.1.02')
         ) &&
         $keuangan->startWith($trx->rekening_kredit, '4.')
     ) {
         $files = 'bm';
         $kuitansi = false;
     }
 @endphp

 <div class="row">
     <div class="col-lg-12 mb-4">
         <div class="card">
             <div class="card-body pt-4 p-3">
                 <h5 class="text-uppercase text-body text-xs font-weight-bolder mb-3">
                     {{ $trx->keterangan }}
                 </h5>
                 <ul class="list-group">
                     <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                         <div class="d-flex align-items-center">
                             <button class="btn btn-outline-danger d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px; border-radius: 50%; padding: 0; border-width: 2px; margin-right: 10px;">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="16"
                                     height="16">
                                     <path
                                         d="M246.6 470.6c-12.5 12.5-32.8 12.5-45.3 0l-160-160c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L224 402.7 361.4 265.4c12.5-12.5 32.8-12.5 45.3 0s12.5 32.8 0 45.3l-160 160zm160-352l-160 160c-12.5 12.5-32.8 12.5-45.3 0l-160-160c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L224 210.7 361.4 73.4c12.5-12.5 32.8-12.5 45.3 0s12.5 32.8 0 45.3z"
                                         fill="red" />
                                 </svg>
                             </button>
                             <div class="d-flex flex-column">
                                 <h6 class="mb-1 text-dark text-sm">
                                     {{ $trx->rek_kredit->kode_akun }} - {{ $trx->rek_kredit->nama_akun }}
                                 </h6>
                                 <span class="text-xs">{{ Tanggal::tglLatin($trx->tgl_transaksi) }}</span>
                             </div>
                         </div>
                         <div class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                             - Rp. {{ number_format($trx->total, 2) }}
                         </div>
                     </li>
                     <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                         <div class="d-flex align-items-center">
                             <button class="btn btn-outline-success d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px; border-radius: 50%; padding: 0; border-width: 2px; margin-right: 10px;">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"width="16" height="16">
                                     <path
                                         d="M246.6 41.4c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 109.3 361.4 246.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-160-160zm160 352l-160-160c-12.5-12.5-32.8-12.5-45.3 0l-160 160c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L224 301.3 361.4 438.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3z"
                                         fill="green" />
                                 </svg>
                             </button>
                             <div class="d-flex flex-column">
                                 <h6 class="mb-1 text-dark text-sm">
                                     {{ $trx->rek_debit->kode_akun }} - {{ $trx->rek_debit->nama_akun }}
                                 </h6>
                                 <span class="text-xs">{{ Tanggal::tglLatin($trx->tgl_transaksi) }}</span>
                             </div>
                         </div>
                         <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                             + Rp. {{ number_format($trx->total, 2) }}
                         </div>
                     </li>
                 </ul>

                 <div class="col-12 d-flex justify-content-end">
                     @if ($kuitansi)
                         <button type="button" class="btn btn-primary btn-icon-split btn-link"
                             data-action="/transactions/dokumen/kuitansi/{{ $trx->id }}">
                             <span class="text" style="float: right;">Kuitansi</span>
                         </button>
                     @endif
                     <button type="button" class="btn btn-info btn-icon-split btn-link"
                         data-action="/transactions/dokumen/{{ $files }}/{{ $trx->id }}"
                         style="float: right; margin-left: 10px;">
                         </span>
                         <span class="text" style="float: right;">{{ $files }}</span>
                     </button>
                 </div>
             </div>
         </div>
     </div>
 </div>
