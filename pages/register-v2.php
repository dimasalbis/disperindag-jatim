<table class="table table-sm  table-borderless">
        <tbody>
           
            <tr>
                <td><?= $Page->name->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_users_name"></slot></td>
                <td></td>
            </tr>

            <tr>
                <td><?= $Page->email->caption() ?></td>
                <td><slot class="ew-slot" name="tpx_users_email"></slot></td>
                <td></td>
            </tr>

            

            
            




            
            
           
            
            

    </table>