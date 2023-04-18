<?php
    function encodeString($regular)
    {
        $encryptedstr = base64_encode($regular);

        return $encryptedstr;
    }

    function decodeString($encrypted)
    {
        $decryptedstr = base64_decode($encrypted);

        return $decryptedstr;
    }
?>