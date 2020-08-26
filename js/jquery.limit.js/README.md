jquery.limit.js
===============

Limit is a plugin for the javascript framework Jquery that limits the number of characters that can be entered in a textarea or input field. The plugin can also report the number of characters left before the user reaches the length limit.How to use LimitTo use the full power of Limit you need two html elements; one textarea or input field and an element to show amount of characters left.

Demo: http://jsfiddle.net/janjarfalk/4kS65/

```html
You have <span id="charsLeft"></span> chars left.
<textarea id="myTextarea"></textarea>
```
```js
    $('#myTextarea').limit('140','#charsLeft');
```
If you don’t want to show the amount of characters left you can do like this.
```js
    $('#myTextarea').limit('140');
```

###Change log
| Version |	Changes |
| ------- | ------- |
| 1.2	| Optimized timed function and fixed an issue with flickering text |
