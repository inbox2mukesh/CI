<?php

/**
 * @package         WOSA
 * @subpackage      IELTS/PTE..
 * @author          Vikram Handa
 *
 * */
trait moveFileTrait
{

    public function auto_move_file_common_to_main($source_file, $destination_path)
    {
      return rename($source_file, $destination_path . pathinfo($source_file, PATHINFO_BASENAME));

    }
}