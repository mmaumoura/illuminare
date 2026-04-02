<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    private const ALLOWED = [
        'theme'         => ['light', 'dark'],
        'theme_primary' => ['blue', 'azure', 'indigo', 'purple', 'pink', 'red', 'orange', 'yellow', 'lime', 'green', 'teal', 'cyan'],
        'theme_base'    => ['slate', 'gray', 'zinc', 'neutral', 'stone'],
        'theme_font'    => ['sans-serif', 'serif', 'monospace', 'comic'],
        'theme_radius'  => ['0', '0.5', '1', '1.5', '2'],
    ];

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'theme'         => 'required|in:light,dark',
            'theme_primary' => 'required|in:blue,azure,indigo,purple,pink,red,orange,yellow,lime,green,teal,cyan',
            'theme_base'    => 'required|in:slate,gray,zinc,neutral,stone',
            'theme_font'    => 'required|in:sans-serif,serif,monospace,comic',
            'theme_radius'  => 'required|in:0,0.5,1,1.5,2',
        ]);

        $request->user()->setting()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $validated
        );

        return response()->json(['success' => true]);
    }

    public function reset(Request $request): JsonResponse
    {
        $request->user()->setting()?->delete();

        return response()->json(['success' => true]);
    }
}
