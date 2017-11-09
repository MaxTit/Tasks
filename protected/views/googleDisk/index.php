<?php
/* @var $this GoogleDiskController */
$this->breadcrumbs=array(
	'Google Disk',
);
?>
<h1>My files modified for the month</h1>

<p>
    <table width="100%">
    <tr>
        <td><H3>File name</H3></td>
        <td><H3>Created time</H3></td>
        <td><H3>Last Change</H3></td>
    </tr>
	<?php
        $files = $this->fileInfo();
        foreach ($files as $file) {
            echo '<tr>
            <td>'.$file->name.'</td>
            <td>'.date("Y-m-d H:i:s", strtotime($file->createdTime)).'</td>
            <td>'.date("Y-m-d H:i:s", strtotime($file->modifiedTime)).'</td>
            </tr>';
        }

    ?>
    </table>
</p>
