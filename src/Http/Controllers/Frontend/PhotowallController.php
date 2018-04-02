<?php

namespace Partymeister\Frontend\Http\Controllers\Frontend;

use Illuminate\Support\Facades\Auth;
use Motor\Backend\Http\Controllers\Controller;

class PhotowallController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitor = Auth::guard('visitor')->user();

        $photos = $this->scanDir(base_path('public/photowall/cache/2018'));

        $limit = 90;
        $page = array_get($_GET, 'page', 1)-1;

        $photos = array_chunk($photos, $limit);

        if (isset($photos[$page]))
        {
            $currentBlock = $photos[$page];
        }
        else
        {
            $currentBlock = $photos[0];
        }

        //$dates = array();
        //foreach ($current_block as $key => $photo)
        //{
        //    $found = FALSE;
        //    foreach ($metadata as $wurst)
        //    {
        //        if ($found) continue;
        //
        //        if (strpos($wurst, str_replace('big_', '', $photo)) !== FALSE)
        //        {
        //            $found = TRUE;
        //            $blah = explode('\t', $wurst);
        //            $dates[$key] = trim(trim($blah[0]));
        //        }
        //    }
        //}

        $pages = count($photos);
        $currentPage = $page+1;
        $photos = $currentBlock;

        $navHighlight = 'photowall';


        return view('partymeister-frontend::frontend.photowall.index', compact('visitor', 'pages', 'currentPage', 'currentBlock', 'photos', 'navHighlight'));
    }


    protected function scanDir($dir)
    {
        $ignored = array(
            '.',
            '..',
            '.svn',
            '.htaccess',
            'Thumbs.db'
        );

        $files = array();
        foreach (scandir($dir) as $file)
        {
            if (in_array($file, $ignored) || strpos($file, 'booth2018') === FALSE)
            {
                continue;
            }
            $files[$file] = $file;
        }

        arsort($files);
        $files = array_keys($files);

        return ($files) ? $files : FALSE;
    }

}
