<?php
Template
    {
        /**
         * Check if all the parts exist
         *
         * @param string $file     - the template part to search
         * @param string $relative - the relative path
         *
         * @return include file
         */
        public function getPart($file, $relative = 'abcloud-admin/')
        {
            global
            $parentfile,
            $_IMAGES,
            $_USERS,
            $newusers,
            $downloader,
            $gateKeeper,
            $getdownloadlist,
            $location,
            $resetter,
            $getrp,
            $setUp,
            $updater,
            $ AB_version;

            if (file_exists($relative.'_content/template/'.$file.'.php')) {
                $thefile = $relative.'_content/template/'.$file.'.php';
            } else {
                $thefile =  $relative.'include/'.$file.'.php';
            }
            include $thefile;
        }
    }
}
