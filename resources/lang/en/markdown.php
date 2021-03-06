<?php

return [
    'header' => 'Markdown grammar',
    'column' => 'Column',
    'content' => 'Content',
    'headings' => [
        'title' => 'Headings',
        'description' => 'To create a heading, add one to six `#` symbols before your heading text. The number of # you use will determine the size of the heading.',
        'example' => "# The largest heading 8-)\n## The second largest heading\n###### The smallest heading",
    ],
    'horizontal_rules' => [
        'title' => 'Horizontal Rules',
        'description' => '',
        'example' => "___\n---\n***",
    ],
    'typographic_replacements' => [
        'title' => 'Typographic replacements',
        'description' => '',
        'example' => "(c) (C) (r) (R) (tm) (TM) (p) (P) +-\n\ntest.. test... test..... test?..... test!....\n\n!!!!!! ???? ,,  -- ---\n\n\"Smartypants, double quotes\" and 'single quotes'",
    ],
    'styling_text' => [
        'title' => 'Styling text',
        'description' => 'You can indicate emphasis with bold, italic, or strikethrough text.',
        'example' => "Style | Syntax | Example | Output |\n----- | --------|----------|--------|\nBold | `** **` or `__ __` | `**This is bold text**` | **This is bold text** |\nItalic | `* *` or `_ _` | `*This text is italicized*` | *This text is italicized* |\nStrikethrough | `~~ ~~` | `~~This was mistaken text~~` | ~~This was mistaken text~~ |\nUnderline | `++ ++` | `++Inserted text++` | ++Inserted text++ |\nMark | `== ==` | `==Marked test==` | ==Marked test== |\nBold and nested italic | `** **` and `_ _` | `**This text is _extremely_ important**` | **This text is _extremely_ important** |",
    ],
    'quoting_text' => [
        'title' => 'Quoting text',
        'description' => 'You can quote text with a <code>></code>.',
        'example' => "> Blockquotes can also be nested...\n>> ...by using additional greater-than signs right next to each other...\n> > > ...or with spaces between arrows.",
    ],
    'quoting_code' => [
        'title' => 'Quoting code',
        'description1' => 'You can call out code or a command within a sentence with single backticks(`). The text within the backticks(`) will not be formatted.',
        'example1' => 'Use `git status` to list all new or modified files that haven\'t yet been committed.',
        'description2' => 'To format code or text into its own distinct block, use triple backticks.',
        'example2' => "Some basic Git commands are:\n```\ngit status\ngit add\ngit commit\n```",
    ],
    'links' => [
        'title' => 'Links',
        'description' => 'You can create an inline link by wrapping link text in brackets <code>[]</code>, and then wrapping the URL in parentheses <code>()</code>. You can also use the keyboard shortcut command + k to create a link.',
        'example' => 'This site was built using [Laravel 5.8](https://laravel.com/docs/5.8).',
    ],
    'lists' => [
        'title' => 'Lists',
        'description1' => 'Unordered',
        'example1' => "+ Create a list by starting a line with `+`, `-`, or `*`\n+ Sub-lists are made by indenting 2 spaces:\n  - Marker character change forces new list start:\n    * Ac tristique libero volutpat at\n    + Facilisis in pretium nisl aliquet\n    - Nulla volutpat aliquam velit\n+ Very easy!",
        'description2' => 'Ordered',
        'example2' => "1. Lorem ipsum dolor sit amet\n2. Consectetur adipiscing elit\n3. Integer molestie lorem at massa\n1. You can use sequential numbers…\n1. …or keep all the numbers as <code>1</code>.",
        'description3' => 'Start numbering with offset:',
        'example3' => "57. foo\n1. bar",
    ],
    'code' => [
        'title' => 'Code',
        'example1' => 'Inline `code`',
        'description2' => 'Indented code',
        'example2' => "    // Some comments\n    line 1 of code\n    line 2 of code\n    line 3 of code",
        'description3' => 'Block code “fences”',
        'example3' => "```\n샘플 문자를 여기에...\n```",
        'description4' => 'Syntax highlighting<br><span class="badge badge-warning font-weight-normal">markup</span> <span class="badge badge-warning font-weight-normal">javascript</span> <span class="badge badge-warning font-weight-normal">css</span> <span class="badge badge-warning font-weight-normal">bash</span> <span class="badge badge-warning font-weight-normal">c</span> <span class="badge badge-warning font-weight-normal">c#</span> <span class="badge badge-warning font-weight-normal">c++</span> <span class="badge badge-warning font-weight-normal">docker</span> <span class="badge badge-warning font-weight-normal">git</span> <span class="badge badge-warning font-weight-normal">java</span> <span class="badge badge-warning font-weight-normal">json</span> <span class="badge badge-warning font-weight-normal">markdown</span> <span class="badge badge-warning font-weight-normal">php</span> <span class="badge badge-warning font-weight-normal">powershell</span> <span class="badge badge-warning font-weight-normal">python</span> <span class="badge badge-warning font-weight-normal">scss</span> <span class="badge badge-warning font-weight-normal">sql</span> <span class="badge badge-warning font-weight-normal">vim</span>',
        'example4' => "```javascript\nlet foo = bar => bar++;\n\nconsole.log(foo(5));\n```",
    ],
    'table' => [
        'title' => 'Tables',
        'description1' => '',
        'example1' => "| Column | Column | Column |\n| ---- | ---- | ---- |\n| Content | Content | Content |",
        'description2' => 'Right aligned columns',
        'example2' => "| Column | Column | Column |\n| ----: | ----: | ----: |\n| Content | Content | Content |",
    ],
    'image' => [
        'title' => 'Images',
        'description' => 'Like links, Images also have a footnote style syntax',
        'example' => "![Minion](https://octodex.github.com/images/minion.png)\n![Stormtroopocat](https://octodex.github.com/images/stormtroopocat.jpg \"The Stormtroopocat\")",
    ],
    'abbreviations' => [
        'title' => 'Abbreviations',
        'example' => "This is HTML abbreviation example.\n\nIt converts “HTML” but keep intact partial entries like “xxxHTMLyyy” and so on.\n\n*[HTML]: Hyper Text Markup Language",
    ],
    'emojies' => [
        'title' => 'Emojies',
        'description' => '<a href="https://github.com/markdown-it/markdown-it-emoji/blob/master/lib/data/shortcuts.js">more emojies</a>',
        'example' => "> Classic markup: :wink: :blush: :cry: :kissing: :laughing: :yum:\n>\n> Shortcuts (emoticons): :-) :-( 8-) ;)",
    ],
    'subscript_superscript' => [
        'title' => 'Subscript / Superscript',
        'example' => "- 19^th^\n- H~2~O",
    ],
    'task_lists' => [
        'title' => 'Task lists',
        'description1' => 'To create a task list, preface list items with a regular space character followed by <code>[]</code>. To mark a task as complete, use <code>[x]</code>.',
        'example1' => "- [x] Finish my changes\n- [ ] Push my commits to GitHub\n- [ ] Open a pull request",
        'description2' => 'If a task list item description begins with a parenthesis, you\'ll need to escape it with <code>\</code>:',
        'example2' => '- [ ] \(Optional) Open a followup issue',
        'description3' => 'For more information, see "<a href="https://help.github.com/en/articles/about-task-lists">About task lists.</a>"',
    ],
    'toolbar' => [
        'bold' => 'Bold',
        'italic' => 'Italic',
        'strikethrough' => 'Strikethrough',
        'heading_bigger' => 'Heading(Bigger)',
        'heading_smaller' => 'Heading(Smaller)',
        'ul' => 'Unordered list',
        'ol' => 'Ordered list',
        'image_upload' => 'Upload image',
        'preview' => 'Preview',
    ],
];
