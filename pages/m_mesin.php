<table class="table table-sm  table-borderless">
            <tr>
                <td><?= $Page->gambar_mesin->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_m_mesin_gambar_mesin"></slot></td>
                <td></td>
            </tr>

            <tr>
                <td><?= $Page->nama_mesin->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_m_mesin_nama_mesin"></slot></td>
                <td></td>
            </tr>

            <tr>
                <td><?= $Page->dalam_penyewaan->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_m_mesin_dalam_penyewaan"></slot></td>
                <td></td>
            </tr>

            <tr>
                <td><?= $Page->sisa_barang->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_m_mesin_sisa_barang"></slot></td>
                <td></td>
            </tr>
            <tr>
                <td><?= $Page->keterangan->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_m_mesin_keterangan"></slot></td>
                <td></td>
            </tr>
            
           
            
           
</table>