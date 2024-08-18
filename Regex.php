<?php

/**
 * Class Regex
 * A fluent interface for building regular expressions.
 */
class Regex
{
    private $pattern = '';
    private $modifiers = '';

    /**
     * Creates a new Regex instance.
     *
     * @return self
     */
    public static function create()
    {
        return new self();
    }

    // Literal String
    public function literal($text)
    {
        $this->pattern .= preg_quote($text, '/');
        return $this;
    }

    // Whitespace
    public function whitespace()
    {
        $this->pattern .= '\s';
        return $this;
    }

    public function nonWhitespace()
    {
        $this->pattern .= '\S';
        return $this;
    }

    // Digits
    public function digit($digits = 1)
    {
        if (!is_int($digits) || $digits <= 0) {
            throw new InvalidArgumentException("The 'digits' parameter must be a positive integer.");
        }
        if ($digits == 1) {
            $this->pattern .= '\d';
        } else {
            $this->pattern .= '\d{' . $digits . '}';
        }
        return $this;
    }

    public function nonDigit()
    {
        $this->pattern .= '\D';
        return $this;
    }

    // Letters
    public function letter($count = 1)
    {
        $this->pattern .= '[A-Za-z]{' . $count . '}';
        return $this;
    }

    public function letters()
    {
        $this->pattern .= '[A-Za-z]+';
        return $this;
    }
    // Letter Case Methods
    public function uppercaseLetters($count = 1)
    {
        $this->pattern .= '[A-Z]{' . $count . '}';
        return $this;
    }

    public function lowercaseLetters($count = 1)
    {
        $this->pattern .= '[a-z]{' . $count . '}';
        return $this;
    }

    public function uppercaseLettersAny()
    {
        $this->pattern .= '[A-Z]+';
        return $this;
    }

    public function lowercaseLettersAny()
    {
        $this->pattern .= '[a-z]+';
        return $this;
    }

    public function wordStartsUppercase()
    {
        $this->pattern .= '[A-Z][a-z]+';
        return $this;
    }

    // Word Characters
    public function word()
    {
        $this->pattern .= '\w+';
        return $this;
    }

    public function nonWord()
    {
        $this->pattern .= '\W+';
        return $this;
    }

    // Special Characters
    public function tab()
    {
        $this->pattern .= '\t';
        return $this;
    }

    public function carriageReturn()
    {
        $this->pattern .= '\r';
        return $this;
    }

    public function newLine()
    {
        $this->pattern .= '\n';
        return $this;
    }

    public function escape($char)
    {
        $this->pattern .= '\\' . $char;
        return $this;
    }

    // Anchors
    public function beginLine()
    {
        // Matches the start of a line (equivalent to '^')
        $this->pattern .= '^';
        return $this;
    }

    public function endLine()
    {
        $this->pattern .= '$';
        return $this;
    }

    public function startOfString()
    {
        $this->pattern .= '^';
        return $this;
    }

    public function endOfString()
    {
        $this->pattern .= '$';
        return $this;
    }

    // Word Boundary
    public function wordBoundary()
    {
        $this->pattern .= '\b';
        return $this;
    }

    // Quantifiers
    public function optional()
    {
        // Matches 0 or 1 of the preceding token
        $this->pattern .= '?';
        return $this;
    }

    public function oneOrMore()
    {
        $this->pattern .= '+';
        return $this;
    }

    public function zeroOrMore()
    {
        $this->pattern .= '*';
        return $this;
    }

    public function atLeastOne()
    {
        $this->pattern .= '+';
        return $this;
    }

    public function anyTimes()
    {
        $this->pattern .= '*';
        return $this;
    }

    public function exactly($n)
    {
        $this->pattern .= '{' . $n . '}';
        return $this;
    }

    public function atLeast($n)
    {
        $this->pattern .= '{' . $n . ',}';
        return $this;
    }

    public function between($min, $max)
    {
        $this->pattern .= '{' . $min . ',' . $max . '}';
        return $this;
    }

    public function lazy()
    {
        $this->pattern .= '?';
        return $this;
    }

    public function times($n)
    {
        $this->pattern .= '{' . $n . '}';
        return $this;
    }

    // Character Class Shortcuts
    public function anyChar()
    {
        // Matches any character (equivalent to '.') except newline
        $this->pattern .= '.';
        return $this;
    }

    public function notNewline()
    {
        // Matches any character except a newline (equivalent to '.')
        $this->pattern .= '.';
        return $this;
    }

    // Character Sets
    public function chars($chars)
    {
        $this->pattern .= '[' . $chars . ']';
        return $this;
    }

    public function notChars($chars)
    {
        $this->pattern .= '[^' . $chars . ']';
        return $this;
    }

    // Groupings
    public function capture($name)
    {
        $this->pattern .= '(?P<' . $name . '>';
        return $this;
    }

    public function endCapture()
    {
        $this->pattern .= ')';
        return $this;
    }

    public function captureGroup($name)
    {
        $this->pattern .= '(?P<' . $name . '>';
        return $this;
    }
    public function startCaptureGroup($name)
    {
        $this->pattern .= '(?P<' . $name . '>';
        return $this;
    }
    public function endCaptureGroup()
    {
        $this->pattern .= ')';
        return $this;
    }

    public function nonCaptureGroup($pattern)
    {
        $this->pattern .= '(?:' . $pattern . ')';
        return $this;
    }

    public function group($pattern)
    {
        $this->pattern .= '(?:' . $pattern . ')';
        return $this;
    }

    // Lookarounds
    public function after($pattern)
    {
        $this->pattern .= '(?=' . preg_quote($pattern, '/') . ')';
        return $this;
    }

    public function before($pattern)
    {
        $this->pattern .= '(?<=' . preg_quote($pattern, '/') . ')';
        return $this;
    }

    public function notAfter($pattern)
    {
        $this->pattern .= '(?!' . preg_quote($pattern, '/') . ')';
        return $this;
    }

    public function notBefore($pattern)
    {
        $this->pattern .= '(?<!' . preg_quote($pattern, '/') . ')';
        return $this;
    }

    public function lookBehind($pattern)
    {
        $this->pattern .= '(?<=' . preg_quote($pattern, '/') . ')';
        return $this;
    }

    public function lookAhead($pattern)
    {
        $this->pattern .= '(?=' . preg_quote($pattern, '/') . ')';
        return $this;
    }

    // Backreferences
    public function backReference($group)
    {
        $this->pattern .= '\g{' . $group . '}';
        return $this;
    }

    // Atomic Groups
    public function atomicGroup($pattern)
    {
        $this->pattern .= '(?>' . $pattern . ')';
        return $this;
    }

    // Alternation
    public function either(...$options)
    {
        $this->pattern .= '(' . implode('|', array_map('preg_quote', $options, array_fill(0, count($options), '/'))) . ')';
        return $this;
    }

    // Modifiers
    public function caseInsensitive()
    {
        $this->modifiers .= 'i';
        return $this;
    }

    public function multiLine()
    {
        $this->modifiers .= 'm';
        return $this;
    }

    // Final Regex
    public function getRegex()
    {
        return '/' . $this->pattern . '/' . $this->modifiers;
    }
}
