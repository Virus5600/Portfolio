<?php
namespace App\CSP_Policies;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Policy;

class Base extends Policy
{
	/**
	 * Defins the list of environments where the application is considered to be in development
	 * and should have certain features enabled.
	 *
	 * @var array
	 */
	private $envArr = [
		'local',
		'development',
		'testing'
	];

	public function configure() {
		$urls = $this->trimExcessWhiteSpace("self " . config("app.url") . " " . config("app.tunnel_url"));

		$this
			// BASIC DIRECTIVES
			->addDirective(Directive::DEFAULT, Keyword::NONE)
			->addDirective(Directive::BASE, Keyword::SELF)
			->addDirective(Directive::CONNECT, Keyword::SELF)
			->addDirective(Directive::DEFAULT, Keyword::SELF)
			->addDirective(Directive::FORM_ACTION, $urls)
			->addDirective(Directive::IMG, "self data: https://*")
			->addDirective(Directive::MEDIA, Keyword::SELF)
			->addDirective(Directive::OBJECT, Keyword::NONE)
			->addDirective(Directive::FONT, "data: {$urls}")

			// FRAME DIRECTIVES
			->addDirective(Directive::FRAME_ANCESTORS, "none")
			->addDirective(Directive::FRAME, "self https://www.facebook.com/")

			// SCRIPTS AND STYLES
			->addDirective(Directive::SCRIPT, $urls)
			->addDirective(Directive::SCRIPT_ELEM, $urls)
			->addDirective(Directive::STYLE, Keyword::UNSAFE_INLINE)
			->addDirective(Directive::STYLE_ELEM, $urls)

			// MUST HAVE NONCE
			->addNonceForDirective(Directive::SCRIPT)
			->addNonceForDirective(Directive::SCRIPT_ELEM)
			->addNonceForDirective(Directive::STYLE_ELEM);

		if (config('app.debug') && in_array(config('app.env'), $this->envArr)) {
			$this->reportOnly();
		}
	}

	public function shouldBeApplied(Request $request, Response $response): bool {
		if (config('app.debug') && ($response->isClientError() || $response->isServerError())) {
			return false;
		}

		return parent::shouldBeApplied($request, $response);
	}

	private function trimExcessWhiteSpace(string $str): string
	{
		return preg_replace("/\s{2,}/", " ", $str);
	}
}
