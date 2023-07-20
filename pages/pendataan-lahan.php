<table class="table table-sm  table-borderless">
        <tbody>
           
            <tr>
                <td><?= $Page->nama_ikm->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_nama_ikm"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->penanggung_jawab->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_penanggung_jawab"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->alamat->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_alamat"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->no_hp->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_no_hp"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->produk->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_produk"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->lokasi_lahan->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_lokasi_lahan"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->luas_lahan->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_luas_lahan"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->nilai_sewa->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_nilai_sewa"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->upload_legalitas->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_upload_legalitas"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->foto_lahan->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_foto_lahan"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->keterangan->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pendataan_lahan_keterangan"></slot></td>
                <td></td>
            </tr>
           
           
           
            
            

    </table>