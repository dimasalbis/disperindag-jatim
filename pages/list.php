<table class="table table-sm  table-borderless">
        <tbody>
           
            <tr>
                <td><?= $Page->nama_mesin->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_nama_mesin"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->spesifikasi->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_spesifikasi"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->jumlah->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_jumlah"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->lama_pembuatan->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_lama_pembuatan"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->pemesan->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_pemesan"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->alamat->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_alamat"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->nomor_kontrak->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_nomor_kontrak"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->tanggal_kontrak->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_tanggal_kontrak"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->nilai_kontrak->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_nilai_kontrak"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->foto_kontrak->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_foto_kontrak"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->upload_ktp->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_upload_ktp"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->foto_mesin->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_foto_mesin"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->status->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_pembuatan_mesin_status"></slot></td>
                <td></td>
            </tr>
            
           
            
            

    </table>