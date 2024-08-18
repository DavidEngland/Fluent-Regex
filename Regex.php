<?php

declare(strict_types=1);

/**
 * Class Regex
 * A fluent interface for building regular expressions.
 *
 * Example usage:
 * $regex = Regex::create()
 *     ->literal('Hello')
 *     ->whitespace()
 *     ->word()
 *     ->endOfString()
 *     ->getRegex();
 */
class Regex
{
    private string $pattern = '';

    /**
     * Creates a new Regex instance.
     *
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * Adds a literal string to the pattern.
     * Special characters are automatically escaped.
     *
     * @param string $text
     * @return self
     */
    public function literal(string $text): self
    {
        $this->pattern .= preg_quote($text, '/');
        return $this;
    }

    /**
     * Adds a whitespace character to the pattern.
     *
     * @return self
     */
    public function whitespace(): self
    {
        $this->pattern .= '\s';
        return $this;
    }

    /**
     * Adds a digit to the pattern.
     *
     * @param int $count
     * @return self
     */
    public function digit(int $count = 1): self
    {
        $this->pattern .= '\d';
        if ($count > 1) {
            $this->pattern .= '{' . $count . '}';
        }
        return $this;
    }

    /**
     * Adds a letter to the pattern.
     *
     * @param int $count
     * @return self
     */
    public function letter(int $count = 1): self
    {
        $this->pattern .= '[A-Za-z]';
        if ($count > 1) {
            $this->pattern .= '{' . $count . '}';
        }
        return $this;
    }

    /**
     * Adds a non-whitespace character to the pattern.
     *
     * @return self
     */
    public function nonWhitespace(): self
    {
        $this->pattern .= '\S';
        return $this;
    }

    /**
     * Starts a named capture group.
     *
     * @param string $name
     * @return self
     */
    public function capture(string $name): self
    {
        $this->pattern .= '(?P<' . $name . '>';
        return $this;
    }

    /**
     * Ends a capture group.
     *
     * @return self
     */
    public function endCapture(): self
    {
        $this->pattern .= ')';
        return $this;
    }

    /**
     * Adds an alternation (either/or) to the pattern.
     *
     * @param string ...$options
     * @return self
     */
    public function either(string ...$options): self
    {
        $this->pattern .= '(' . implode('|', array_map(fn($option) => preg_quote($option, '/'), $options)) . ')';
        return $this;
    }

    /**
     * Adds an end-of-string anchor to the pattern.
     *
     * @return self
     */
    public function endOfString(): self
    {
        $this->pattern .= '$';
        return $this;
    }

    /**
     * Adds a quantifier for at least one occurrence.
     *
     * @return self
     */
    public function atLeastOne(): self
    {
        $this->pattern .= '+';
        return $this;
    }

    /**
     * Adds a quantifier for zero or more occurrences.
     *
     * @return self
     */
    public function anyTimes(): self
    {
        $this->pattern .= '*';
        return $this;
    }

    /**
     * Adds a quantifier for an optional occurrence.
     *
     * @return self
     */
    public function optional(): self
    {
        $this->pattern .= '?';
        return $this;
    }

    /**
     * Adds a pattern for any character (zero or more).
     *
     * @return self
     */
    public function anything(): self
    {
        $this->pattern .= '.*';
        return $this;
    }

    /**
     * Adds a lazy quantifier.
     *
     * @return self
     */
    public function lazy(): self
    {
        $this->pattern .= '?';
        return $this;
    }

    /**
     * Adds a word boundary to the pattern.
     *
     * @return self
     */
    public function wordBoundary(): self
    {
        $this->pattern .= '\b';
        return $this;
    }

    /**
     * Adds a lookbehind assertion to the pattern.
     *
     * @param string $pattern
     * @return self
     */
    public function lookBehind(string $pattern): self
    {
        $this->pattern .= '(?<=' . preg_quote($pattern, '/') . ')';
        return $this;
    }

    /**
     * Adds a word character to the pattern.
     *
     * @return self
     */
    public function word(): self
    {
        $this->pattern .= '\w';
        return $this;
    }

    /**
     * Returns the complete regex pattern.
     *
     * @return string
     */
    public function getRegex(): string
    {
        return '/' . $this->pattern . '/';
    }

    /**
     * Resets the pattern to an empty string.
     *
     * @return self
     */
    public function reset(): self
    {
        $this->pattern = '';
        return $this;
    }

    /**
     * Compiles the regex pattern for direct use.
     *
     * @return \Closure
     */
    public function compile(): \Closure
    {
        $regex = $this->getRegex();
        return fn(string $subject): bool => (bool)preg_match($regex, $subject);
    }
}
