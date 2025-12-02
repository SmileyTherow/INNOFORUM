<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost:8000";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.5.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.5.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-endpoints" class="tocify-header">
                <li class="tocify-item level-1" data-unique="endpoints">
                    <a href="#endpoints">Endpoints</a>
                </li>
                                    <ul id="tocify-subheader-endpoints" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="endpoints-GETapi-events">
                                <a href="#endpoints-GETapi-events">GET api/events</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: November 13, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost:8000</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="endpoints">Endpoints</h1>

    

                                <h2 id="endpoints-GETapi-events">GET api/events</h2>

<p>
</p>



<span id="example-requests-GETapi-events">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/events" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/events"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-events">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
x-ratelimit-limit: 60
x-ratelimit-remaining: 59
access-control-allow-origin: *
set-cookie: XSRF-TOKEN=eyJpdiI6IkM5bHI3cGxselFVcm9tdU5MU2Jaa0E9PSIsInZhbHVlIjoiMGk4L3VXT3ZOQVJyd3ZEeisvTnRNOE5SWFhrbnRRaS9GbkdtTHdYUGVBM3VHamJZYW1xRXloaUJqY3dZMnhXaFhxLzZpa0VMTjhBOE91OEV5SURuOTFqWHBBeUZFYWJTK1V0dWJsUFdqZHIwaVAwbEt0L0x5cHNiZmpYVnNkdUIiLCJtYWMiOiI0NWFlNDJiZjM1YzdlYzdlZmVmODE5Y2E4MmE3OGJhODViZGEzYTBiNTc2MzhjYTA3YzljYjhhY2Q4ZDc3NGFjIiwidGFnIjoiIn0%3D; expires=Thu, 13 Nov 2025 07:39:12 GMT; Max-Age=600; path=/; samesite=lax; laravel_session=eyJpdiI6ImtwNEx5enlISjFwQ1BDajdzMnNvSlE9PSIsInZhbHVlIjoiMzZBNi9wcFlzNHNJZTdQU0FmRFFnUnhrWjFuSXBhVm1LeU41NnNWa3k4L0liTEVoOFB1QTR6NlJ6ZmtpWlRkUDFRVXdvbSt6RFFuaTVVUktxWmh6L1lHd2F0OFZmTzJRL3BnQjBrSnpMbG43MVpRUXVhcFpMZTNMQzgwMTNYbDkiLCJtYWMiOiIwNjM0NGU0YTNiYWEzYzBhMTAzMjNjMmRmM2M0NzA3YzFhYWIxNGMxYmYwMDlhOWE0ODhlM2MxMjU0M2MzNGJmIiwidGFnIjoiIn0%3D; path=/; httponly; samesite=lax
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">[
    {
        &quot;id&quot;: 2,
        &quot;title&quot;: &quot;test&quot;,
        &quot;description&quot;: &quot;test aja&quot;,
        &quot;start_date&quot;: &quot;2025-11-01&quot;,
        &quot;end_date&quot;: &quot;2025-11-07&quot;,
        &quot;start&quot;: &quot;2025-11-01&quot;,
        &quot;end&quot;: &quot;2025-11-07&quot;,
        &quot;color&quot;: &quot;red&quot;,
        &quot;is_published&quot;: true,
        &quot;created_by&quot;: 101,
        &quot;url&quot;: &quot;http://localhost:8000/kalender/event/2&quot;
    },
    {
        &quot;id&quot;: 3,
        &quot;title&quot;: &quot;test&quot;,
        &quot;description&quot;: &quot;tes&quot;,
        &quot;start_date&quot;: &quot;2025-11-16&quot;,
        &quot;end_date&quot;: &quot;2025-11-18&quot;,
        &quot;start&quot;: &quot;2025-11-16&quot;,
        &quot;end&quot;: &quot;2025-11-18&quot;,
        &quot;color&quot;: &quot;yellow&quot;,
        &quot;is_published&quot;: true,
        &quot;created_by&quot;: 101,
        &quot;url&quot;: &quot;http://localhost:8000/kalender/event/3&quot;
    },
    {
        &quot;id&quot;: 6,
        &quot;title&quot;: &quot;rest&quot;,
        &quot;description&quot;: &quot;rest&quot;,
        &quot;start_date&quot;: &quot;2025-11-13&quot;,
        &quot;end_date&quot;: &quot;2025-11-14&quot;,
        &quot;start&quot;: &quot;2025-11-13&quot;,
        &quot;end&quot;: &quot;2025-11-14&quot;,
        &quot;color&quot;: &quot;green&quot;,
        &quot;is_published&quot;: true,
        &quot;created_by&quot;: 101,
        &quot;url&quot;: &quot;http://localhost:8000/kalender/event/6&quot;
    },
    {
        &quot;id&quot;: 12,
        &quot;title&quot;: &quot;ping&quot;,
        &quot;description&quot;: &quot;test&quot;,
        &quot;start_date&quot;: &quot;2025-11-21&quot;,
        &quot;end_date&quot;: &quot;2025-11-22&quot;,
        &quot;start&quot;: &quot;2025-11-21&quot;,
        &quot;end&quot;: &quot;2025-11-22&quot;,
        &quot;color&quot;: &quot;purple&quot;,
        &quot;is_published&quot;: true,
        &quot;created_by&quot;: 101,
        &quot;url&quot;: &quot;http://localhost:8000/kalender/event/12&quot;
    },
    {
        &quot;id&quot;: 13,
        &quot;title&quot;: &quot;test&quot;,
        &quot;description&quot;: &quot;set sistem&quot;,
        &quot;start_date&quot;: &quot;2025-11-10&quot;,
        &quot;end_date&quot;: &quot;2025-11-11&quot;,
        &quot;start&quot;: &quot;2025-11-10&quot;,
        &quot;end&quot;: &quot;2025-11-11&quot;,
        &quot;color&quot;: &quot;purple&quot;,
        &quot;is_published&quot;: true,
        &quot;created_by&quot;: 101,
        &quot;url&quot;: &quot;http://localhost:8000/kalender/event/13&quot;
    },
    {
        &quot;id&quot;: 19,
        &quot;title&quot;: &quot;tes sistem kalender&quot;,
        &quot;description&quot;: &quot;test&quot;,
        &quot;start_date&quot;: &quot;2025-11-25&quot;,
        &quot;end_date&quot;: &quot;2025-11-25&quot;,
        &quot;start&quot;: &quot;2025-11-25&quot;,
        &quot;end&quot;: &quot;2025-11-25&quot;,
        &quot;color&quot;: &quot;blue&quot;,
        &quot;is_published&quot;: true,
        &quot;created_by&quot;: 101,
        &quot;url&quot;: &quot;http://localhost:8000/kalender/event/19&quot;
    },
    {
        &quot;id&quot;: 20,
        &quot;title&quot;: &quot;tes sistem kalender&quot;,
        &quot;description&quot;: null,
        &quot;start_date&quot;: &quot;2025-11-27&quot;,
        &quot;end_date&quot;: &quot;2025-11-28&quot;,
        &quot;start&quot;: &quot;2025-11-27&quot;,
        &quot;end&quot;: &quot;2025-11-28&quot;,
        &quot;color&quot;: &quot;red&quot;,
        &quot;is_published&quot;: true,
        &quot;created_by&quot;: 101,
        &quot;url&quot;: &quot;http://localhost:8000/kalender/event/20&quot;
    }
]</code>
 </pre>
    </span>
<span id="execution-results-GETapi-events" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-events"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-events"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-events" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-events">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-events" data-method="GET"
      data-path="api/events"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-events', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-events"
                    onclick="tryItOut('GETapi-events');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-events"
                    onclick="cancelTryOut('GETapi-events');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-events"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/events</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-events"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-events"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
