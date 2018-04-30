## Contributing

:+1::tada: First off, thanks for taking the time to contribute! :tada::+1:

The following is a set of guidelines for contributing to Weglot and its packages, which are hosted in the [Weglot Organization](https://github.com/weglot) on GitHub. These are mostly guidelines, not rules. Use your best judgment, and feel free to propose changes to this document in a pull request.

### Opening an issue

Each repository provides a template for issues. First, we need to know if it's a bug report or a feature report.
Then what you expected to happen, a clear description of the problem you're facing, steps to reproduce and environment details: the client and language version are a big help.

### Submitting a pull request

Keep your changes as focused as possible. If there are multiple changes you'd like to make,
please consider submitting them as separate pull requests unless they are related to each other.

Here are a few tips to increase the likelihood of being merged:

* Fill in [the required template](PULL_REQUEST_TEMPLATE.md)
* Do not include issue numbers in the PR title
* Include screenshots and animated GIFs in your pull request whenever possible.
* Follow our [code styleguide](#styleguides).
* Document new code based on PHPDoc.
* Write tests.
* Write a [good commit message](http://tbaggery.com/2008/04/19/a-note-about-git-commit-messages.html).

### Styleguides

Generally, we follow the style guidelines as suggested by the official language.
However, we ask that you conform to the styles that already exist in the library.
If you wish to deviate, please explain your reasoning.

- [PSR1 Basic Coding Standard](https://www.php-fig.org/psr/psr-1/)
- [PSR2 Coding Style Guide](https://www.php-fig.org/psr/psr-2/)
- Forcing array with short syntax: `[]`
- Replace control structure alternative syntax to use braces.

Please run your code through:
[PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)

We provide configuration for this tool through [`.php_cs`](./.php_cs) file.

### Security issues
If you find any security risk in the project, please open an issue or contact us at `support@weglot.com` regarding the impact.

### API Breaking changes
We care deeply about backward compatibility for our API clients libraries.
If it's necessary, we're ready to break backward compatibility,
but this should be pretty rare.

If you want to make a change that will break the backward compatibility of the API,
open an issue first to discuss it with the maintainers.

## Resources
- [Contributing to Open Source on GitHub](https://guides.github.com/activities/contributing-to-open-source/)
- [Using Pull Requests](https://help.github.com/articles/using-pull-requests/)
- [GitHub Help](https://help.github.com)