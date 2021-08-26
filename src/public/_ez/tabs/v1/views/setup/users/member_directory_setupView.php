<?php
/**
 * Created by PhpStorm.
 * User: micah
 * Date: 5/1/2020
 * Time: 3:39 PM
 */

?>
<table class="table table-striped entityList">
    <thead>
    <tr>
        <th><a class="sortasc">Id</a></th>
        <th><a class="sortasc">Name</a></th>
        <th><a class="sortasc">Phone</a></th>
        <th><a class="sortasc">Email</a></th>
        <th><a class="sortasc">Last Updated</a></th>
        <th class="text-right">Actions</th>
    </tr>
    </thead>
    <tbody>
    <h5>Directory Members <span class="pointer addNewEntityButton entityButtonFixInTitle"></span></h5>
    <?php $objMemberDirectoryResult->Data->Each(function($currMember) {
        /** @var $currMember \Modules\Contacts\Models\ContactMemberDirectoryModel */
        ?>
    <tr>
        <td><?php echo $currMember->directory_page_rel_id; ?></td>
        <td><?php echo $currMember->first_name . " " . $currMember->last_name; ?></td>
        <td><?php echo $currMember->mobile_phone; ?></td>
        <td><?php echo $currMember->email_address; ?></td>
        <td><?php echo $currMember->last_updated; ?></td>
        <td>
            <span class="pointer editEntityButton"></span>
            <span class="pointer deleteEntityButton"></span>
        </td>
    <?php }); ?>


<div>

</div>
