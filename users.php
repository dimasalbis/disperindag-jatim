<table class="table table-sm  table-borderless">
            <tr>
                <td><?= $Page->name->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_users_name"></slot></td>
                <td></td>
            </tr>
            
            <tr>
                <td><?= $Page->level->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_users_level"></slot></td>
                <td></td>
            </tr>
            
            
           
</table>