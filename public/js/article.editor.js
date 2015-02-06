// define fields
var article = document.querySelector('article');

editor.launch(
[
    {   
        field: article.querySelector('h1'), 
        type: 'text',
        placeholder: '[titel]'
    }, 
    {
        field: article.querySelector('div[itemprop="articleBody"]'), 
        type: 'html',
        placeholder: '[content]'
    }
]);