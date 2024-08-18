# Fluent Regex Builder for PHP

This library provides a fluent interface for building regular expressions in PHP. It aims to make creating complex regexes easier and more readable by offering a more natural and human-friendly way to construct patterns.

## Installation

```bash
composer require your-username/fluent-regex
```

## Usage

### Basic Building Blocks

* **Literal Strings:** Use `literal()` to match literal text, escaping special characters automatically.
   ```php
   $regex = Regex::create()->literal('Hello, world!');
   echo $regex->getRegex(); // Output: /Hello,\ world!/ 
   ```

* **Whitespace:** Use `whitespace()` to match a single whitespace character.
   ```php
   $regex = Regex::create()->whitespace();
   echo $regex->getRegex(); // Output: /\s/
   ```

* **Non-Whitespace:** Use `nonWhitespace()` to match a single non-whitespace character.
   ```php
   $regex = Regex::create()->nonWhitespace();
   echo $regex->getRegex(); // Output: /\S/
   ```

* **Digits:** Use `digit()` to match a single digit or `digit(n)` to match `n` consecutive digits.
   ```php
   $regex = Regex::create()->digit();       // Matches a single digit: /\d/
   $regex = Regex::create()->digit(3);      // Matches three digits: /\d{3}/
   ```

* **Non-Digits:** Use `nonDigit()` to match a single non-digit character.
   ```php
   $regex = Regex::create()->nonDigit();
   echo $regex->getRegex(); // Output: /\D/
   ```

* **Letters:** Use `letter()` to match a single letter, `letters()` for one or more letters, `uppercaseLetters(n)` for `n` uppercase letters, `uppercaseLettersAny()` for one or more uppercase letters,  `lowercaseLetters(n)` for `n` lowercase letters,  `lowercaseLettersAny()` for one or more lowercase letters.
   ```php
   $regex = Regex::create()->letter();         // Matches a single letter: /[A-Za-z]/
   $regex = Regex::create()->letters();        // Matches one or more letters: /[A-Za-z]+/
   $regex = Regex::create()->uppercaseLetters(2); // Matches two uppercase letters: /[A-Z]{2}/
   $regex = Regex::create()->uppercaseLettersAny(); // Matches one or more uppercase letters: /[A-Z]+/
   $regex = Regex::create()->lowercaseLetters(2); // Matches two lowercase letters: /[a-z]{2}/
   $regex = Regex::create()->lowercaseLettersAny(); // Matches one or more lowercase letters: /[a-z]+/
   ```

* **Word Characters:** Use `word()` to match one or more word characters (alphanumeric and underscore).
   ```php
   $regex = Regex::create()->word();
   echo $regex->getRegex(); // Output: /\w+/
   ```

* **Non-Word Characters:** Use `nonWord()` to match one or more non-word characters.
   ```php
   $regex = Regex::create()->nonWord();
   echo $regex->getRegex(); // Output: /\W+/
   ```

* **Special Characters:** Use `tab()`, `carriageReturn()`, and `newLine()` to match tab, carriage return, and newline characters, respectively.
   ```php
   $regex = Regex::create()->tab();
   echo $regex->getRegex(); // Output: /\t/

   $regex = Regex::create()->carriageReturn();
   echo $regex->getRegex(); // Output: /\r/

   $regex = Regex::create()->newLine();
   echo $regex->getRegex(); // Output: /\n/
   ```

* **Escaping:** Use `escape($char)` to escape a specific character in your pattern.
   ```php
   $regex = Regex::create()->escape('.');
   echo $regex->getRegex(); // Output: /\./
   ```

### Anchors

* **Start of String:** Use `startOfString()` or `beginLine()` to match the beginning of a string or line.
   ```php
   $regex = Regex::create()->startOfString()->literal('Hello');
   echo $regex->getRegex(); // Output: /^Hello/

   $regex = Regex::create()->beginLine()->literal('Hello');
   echo $regex->getRegex(); // Output: /^Hello/ 
   ```

* **End of String:** Use `endOfString()` or `endLine()` to match the end of a string or line.
   ```php
   $regex = Regex::create()->literal('world')->endOfString();
   echo $regex->getRegex(); // Output: /world$/

   $regex = Regex::create()->literal('world')->endLine();
   echo $regex->getRegex(); // Output: /world$/
   ```

* **Word Boundary:** Use `wordBoundary()` to match a position between a word character and a non-word character.
   ```php
   $regex = Regex::create()->wordBoundary()->literal('world')->wordBoundary();
   echo $regex->getRegex(); // Output: /\bworld\b/
   ```

### Quantifiers

* **Optional:** Use `optional()` to match the preceding pattern zero or one time.
   ```php
   $regex = Regex::create()->literal('abc')->optional();
   echo $regex->getRegex(); // Output: /abc?/
   ```

* **One or More:** Use `oneOrMore()` to match the preceding pattern one or more times.
   ```php
   $regex = Regex::create()->letter()->oneOrMore();
   echo $regex->getRegex(); // Output: /[A-Za-z]+/
   ```

* **Zero or More:** Use `zeroOrMore()` to match the preceding pattern zero or more times.
   ```php
   $regex = Regex::create()->digit()->zeroOrMore();
   echo $regex->getRegex(); // Output: /\d*/
   ```

* **Exactly:** Use `exactly($n)` to match the preceding pattern exactly `$n` times.
   ```php
   $regex = Regex::create()->digit()->exactly(3);
   echo $regex->getRegex(); // Output: /\d{3}/
   ```

* **At Least:** Use `atLeast($n)` to match the preceding pattern at least `$n` times.
   ```php
   $regex = Regex::create()->letter()->atLeast(2);
   echo $regex->getRegex(); // Output: /[A-Za-z]{2,}/
   ```

* **Between:** Use `between($min, $max)` to match the preceding pattern between `$min` and `$max` times.
   ```php
   $regex = Regex::create()->digit()->between(1, 3);
   echo $regex->getRegex(); // Output: /\d{1,3}/
   ```

* **Lazy:** Use `lazy()` to make the preceding quantifier match as few characters as possible.
   ```php
   $regex = Regex::create()->anything()->lazy();
   echo $regex->getRegex(); // Output: /.*?/
   ```

* **Times:** Use `times($n)` to match the preceding pattern exactly `$n` times.
   ```php
   $regex = Regex::create()->digit()->times(3);
   echo $regex->getRegex(); // Output: /\d{3}/
   ```

### Character Class Shortcuts

* **Any Character:** Use `anyChar()` to match any character (except newline).
   ```php
   $regex = Regex::create()->anyChar();
   echo $regex->getRegex(); // Output: /.
   ```

* **Any Character (Including Newline):** Use `anyCharIncludingNewline()` to match any character, including newline.
   ```php
   $regex = Regex::create()->anyCharIncludingNewline();
   echo $regex->getRegex(); // Output: /./s
   ```

* **Not Newline:** Use `notNewline()` to match any character except a newline.
   ```php
   $regex = Regex::create()->notNewline();
   echo $regex->getRegex(); // Output: /.
   ```

* **Character Sets:** Use `chars($chars)` to match characters within the specified set.
   ```php
   $regex = Regex::create()->chars('a-zA-Z');
   echo $regex->getRegex(); // Output: /[a-zA-Z]/
   ```

* **Negated Character Sets:** Use `notChars($chars)` to match any character NOT in the specified set.
   ```php
   $regex = Regex::create()->notChars('0-9');
   echo $regex->getRegex(); // Output: /[^0-9]/
   ```

### Groupings

* **Capture Group:** Use `startCaptureGroup($name)` and `endCaptureGroup()` to start and end a named capture group.
   ```php
   $regex = Regex::create()
       ->startCaptureGroup('name')
       ->letters()->anyTimes()
       ->endCaptureGroup();
   echo $regex->getRegex(); // Output: /(?P<name>[A-Za-z]+)/
   ```

* **Non-Capturing Group:** Use `nonCaptureGroup($pattern)` to create a non-capturing group.
   ```php
   $regex = Regex::create()
       ->nonCaptureGroup('(abc|def)')
       ->getRegex(); // Output: /(?:(abc|def))/
   ```

* **Capture:** Use `capture($name)` and `endCapture()` for named capture groups.
   ```php
   $regex = Regex::create()
       ->capture('name')
       ->letters()->anyTimes()
       ->endCapture();
   echo $regex->getRegex(); // Output: /(?P<name>[A-Za-z]+)/
   ```

### Lookarounds

* **Lookahead:** Use `after($pattern)` or `lookAhead($pattern)` to match the current position if it is followed by the specified pattern.
   ```php
   $regex = Regex::create()->letter()->after(' ');
   echo $regex->getRegex(); // Output: /[A-Za-z](?=\s)/
   ```

* **Lookbehind:** Use `before($pattern)` or `lookBehind($pattern)` to match the current position if it is preceded by the specified pattern.
   ```php
   $regex = Regex::create()->letter()->before(' ');
   echo $regex->getRegex(); // Output: /(?<=\s)[A-Za-z]/
   ```

* **Negative Lookahead:** Use `notAfter($pattern)` to match the current position if it is NOT followed by the specified pattern.
   ```php
   $regex = Regex::create()->letter()->notAfter(' ');
   echo $regex->getRegex(); // Output: /[A-Za-z](?!\s)/
   ```

* **Negative Lookbehind:** Use `notBefore($pattern)` to match the current position if it is NOT preceded by the specified pattern.
   ```php
   $regex = Regex::create()->letter()->notBefore(' ');
   echo $regex->getRegex(); // Output: /(?<!\s)[A-Za-z]/
   ```

### Backreferences

* **Backreference:** Use `backReference($group)` to refer to a previously captured group.
   ```php
   $regex = Regex::create()
       ->capture('group1')
       ->letters()->anyTimes()
       ->endCapture()
       ->literal('-')
       ->backReference('group1');
   echo $regex->getRegex(); // Output: /(?P<group1>[A-Za-z]+)-\g{1}/
   ```

### Atomic Groups

* **Atomic Group:** Use `atomicGroup($pattern)` to create an atomic group.
   ```php
   $regex = Regex::create()->atomicGroup('(abc|def)');
   echo $regex->getRegex(); // Output: /(?>(abc|def))/
   ```

### Alternation

* **Either/Or:** Use `either(...$options)` to create an alternation (either/or) condition.
   ```php
   $regex = Regex::create()
       ->either('cat', 'dog', 'bird');
   echo $regex->getRegex(); // Output: /(cat|dog|bird)/
   ```

### Modifiers

* **Case-Insensitive:** Use `caseInsensitive()` to make the regex case-insensitive.
   ```php
   $regex = Regex::create()
       ->letter()->anyTimes()
       ->caseInsensitive();
   echo $regex->getRegex(); // Output: /[A-Za-z]+/i
   ```

* **Multi-Line:** Use `multiLine()` to enable multi-line mode (makes `^` and `$` match the start and end of each line).
   ```php
   $regex = Regex::create()
       ->beginLine()
       ->literal('Hello')
       ->endLine()
       ->multiLine();
   echo $regex->getRegex(); // Output: /^Hello$/m
   ```

### Final Regex

* **getRegex()**:  Use `getRegex()` to retrieve the final constructed regular expression string.
   ```php
   $regex = Regex::create()
       ->startCaptureGroup('name')
       ->letters()->anyTimes()
       ->endCaptureGroup()
       ->getRegex();
   echo $regex; // Output: /(?P<name>[A-Za-z]+)/
   ```

## Examples

Here are some examples demonstrating how to combine different methods:

* **Matching Email Addresses:**
   ```php
   $regex = Regex::create()
       ->startCaptureGroup('username')
       ->letters()->oneOrMore()
       ->endCaptureGroup()
       ->literal('@')
       ->startCaptureGroup('domain')
       ->letters()->oneOrMore()
       ->endCaptureGroup()
       ->literal('.')
       ->startCaptureGroup('tld')
       ->letters()->exactly(2)
       ->endCaptureGroup();
   echo $regex->getRegex(); 
   // Output: /(?P<username>[A-Za-z]+)@(?P<domain>[A-Za-z]+)\.(?P<tld>[A-Za-z]{2})/
   ```

* **Matching Phone Numbers:**
   ```php
   $regex = Regex::create()
       ->literal('(')
       ->digit(3)
       ->literal(')')
       ->whitespace()
       ->digit(3)
       ->literal('-')
       ->digit(4);
   echo $regex->getRegex(); 
   // Output: /\(\d{3}\)\s\d{3}-\d{4}/
   ```

* **Matching URLs:**
   ```php
   $regex = Regex::create()
       ->literal('http')
       ->optional()
       ->literal('s')
       ->optional()
       ->literal('://')
       ->startCaptureGroup('domain')
       ->letters()->anyTimes()
       ->endCaptureGroup();
   echo $regex->getRegex();
   // Output: /http(?:s)?:\/\/(?P<domain>[A-Za-z]+)/
   ```

## Contributing

Contributions are welcome! Please open an issue or submit a pull request if you have any suggestions or improvements.

## License

This library is licensed under the MIT License.# Fluent-Regex
Natural Language regex builder in PHP
