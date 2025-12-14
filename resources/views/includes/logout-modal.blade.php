<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- HEADER DENGAN WARNA BIRU -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">
                    <i class="fas fa-sign-out-alt"></i> Konfirmasi Logout
                </h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-question-circle fa-3x text-primary"></i>
                </div>
                <p class="text-center mb-0">Apakah Anda yakin ingin keluar dari sesi ini?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-out-alt"></i> Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>