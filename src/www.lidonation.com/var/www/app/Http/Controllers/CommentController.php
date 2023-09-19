<?php

namespace App\Http\Controllers;

use App\Repositories\CommentRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

/**
 * Class CommentController
 */
class CommentController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function store(Request $request, CommentRepository $commentRepository): RedirectResponse
    {
        $this->validate($request, [
            'content' => 'required',
            'g-recaptcha-response' => [new GoogleReCaptchaV3ValidationRule('post_comment')],
        ]);

        $data = $request->all();
        if (! $request->input('meta') !== null) {
            $meta = [];
            // Maybe save meta
            if ($request->input('name')) {
                $meta['name'] = $request->input('name');
                unset($data['name']);
            }

            if ($request->input('email')) {
                $meta['email'] = $request->input('email');
                unset($data['email']);
            }
            $data['meta'] = $meta;
        }

        $commentRepository->create($data);

        return back()
            ->with('message', 'Thanks for your comment! It will be reviewed and posted shortly.');
    }
}
