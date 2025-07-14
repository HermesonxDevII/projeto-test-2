<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Alaouy\Youtube\Facades\Youtube;

class DataYoutubeController extends Controller
{
    //MelisEducation ID Channel - UCotIB3ysAs4sNIzfpMeaKyw

    public function getVideos(): JsonResponse
    {
        try {
            //lista videos do canal, limit 20, order by data de envio
            $videos = Youtube::listChannelVideos('UCotIB3ysAs4sNIzfpMeaKyw', 30, 'date');

            //array de paginação
            $videos = array_chunk($videos, 6);
            //array de paginação

            return response()->json($videos, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Algo deu errado.'
            ], 500);
        }
    }

    public function getSearch($keywords): JsonResponse
    {
        try {
            $listSearch = Youtube::searchChannelVideos($keywords, 'UCotIB3ysAs4sNIzfpMeaKyw', 30);

            //array de paginação
            if(!empty($listSearch)) {
                $videos = array_chunk($listSearch, 6);
                return response()->json($videos, 200);
            }
            //array de paginação

            return response()->json($listSearch, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'icon' => 'error',
                'msg'  => $ex
            ], 500);
        }
    }

    public function playlists(): JsonResponse
    {
        try {
            // Get playlist by channel ID, return an array of PHP objects
            $listPlaylists = Youtube::getPlaylistsByChannelId('UCotIB3ysAs4sNIzfpMeaKyw');

            return response()->json($listPlaylists, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Algo deu errado.'
            ], 500);
        }
    }

    public function playlistsById($id): JsonResponse
    {
        try {
            // Get playlist by ID, return an STD PHP object
            $playlist = Youtube::getPlaylistById('PL590L5WQmH8fJ54F369BLDSqIwcs-TCfs');

            // Get playlists by multiple ID's, return an array of STD PHP objects
            $playlists = Youtube::getPlaylistById(['PL590L5WQmH8fJ54F369BLDSqIwcs-TCfs', 'PL590L5WQmH8cUsRyHkk1cPGxW0j5kmhm0']);

            return response()->json($playlists, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Algo deu errado.'
            ], 500);
        }
    }

    public function videoInfo($id): JsonResponse
    {
        try {
            // Return the video infos
            $video = Youtube::getVideoInfo($id);

            return response()->json($video, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'icon' => 'error',
                'msg'  => 'Algo deu errado.'
            ], 500);
        }
    }

}
