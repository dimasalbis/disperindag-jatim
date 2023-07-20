<table class="table table-sm  table-borderless">
            <tr>
                <td><?= $Page->nama_perusahaan->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_perusahaan_penampung_nama_perusahaan"></slot></td>
                <td></td>
            </tr>

            <tr>
                <td><?= $Page->alamat->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_perusahaan_penampung_alamat"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->no_telpon->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_perusahaan_penampung_no_telpon"></slot></td>
                <td></td>
            </tr>

            <tr>
                <td><?= $Page->contact_person->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_perusahaan_penampung_contact_person"></slot></td>
                <td></td>
            </tr>

            <tr>
                <td><?= $Page->bidang->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_perusahaan_penampung_bidang"></slot></td>
                <td></td>
            </tr>

            <tr>
                <td><?= $Page->keterangan->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_perusahaan_penampung_keterangan"></slot></td>
                <td></td>
            </tr>



           
            
           
</table>