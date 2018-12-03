<?php
/**
 * statistics article pageview
 * @author K
 *
 */

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Redis;
use Closure;
use App\Jobs\StatisticsArticleView;

class ViewStatistics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if($response->status() == '200')
        {
            //the unique fingerprint for the request / route / IP address.
            $fingerprint = $request->fingerprint();
            if(!Redis::exists($fingerprint))
            {
                //cache the fingerpring which expires in 60*6 seconds
                Redis::setex($fingerprint, 60*6, $request->getClientIp());
                //dispatch the job
                StatisticsArticleView::dispatch($response->getOriginalContent()->article)
                ->onQueue('pageviews');
            }
        }
        return $response;
    }
}
