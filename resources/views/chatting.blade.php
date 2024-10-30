<div class="offcanvas offcanvas-end" tabindex="-1" id="chatDrawer" aria-labelledby="chatDrawerLabel">
    <div class="offcanvas-header">
        <h5 id="chatDrawerLabel" class="offcanvas-title">Chatting</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form class="mb-6">
            <div id="message" class="d-flex flex-column h-200px bg-light mb-3 overflow-auto">
                <!-- Chat messages will be appended here -->
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" id="nama" placeholder="Nama" class="form-control mb-2" />
                <label for="description" class="form-label">Pesan</label>
                <textarea id="description" rows="4" class="form-control" placeholder="Tulis pesan disini"></textarea>
            </div>
            <button id="kirim" type="button" class="btn btn-primary w-100">Kirim</button>
        </form>
    </div>
</div>