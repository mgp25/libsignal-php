<?php
require_once("java/util/NoSuchElementException.php");
class Preconditions {
	private function __init() { // default class members
	}
	public static function __staticinit() { // static class members
	}
	public static function constructor__ () 
	{
		$me = new self();
		$me->__init();
		return $me;
	}
	public static function checkArgument_3db6c28 ($expression) // [boolean expression]
	{
		if (!$expression)
		{
			throw new IllegalArgumentException();
		}
	}
	public static function checkArgument_67b7a356 ($expression, $errorMessage) // [boolean expression, Object errorMessage]
	{
		if (!$expression)
		{
			throw new IllegalArgumentException($String->valueOf($errorMessage));
		}
	}
	public static function checkArgument_14cc2f56 ($expression, $errorMessageTemplate, $errorMessageArgs) // [boolean expression, String errorMessageTemplate, Object... errorMessageArgs]
	{
		if (!$expression)
		{
			throw new IllegalArgumentException(self::format($errorMessageTemplate, $errorMessageArgs));
		}
	}
	public static function checkState_3db6c28 ($expression) // [boolean expression]
	{
		if (!$expression)
		{
			throw new IllegalStateException();
		}
	}
	public static function checkState_67b7a356 ($expression, $errorMessage) // [boolean expression, Object errorMessage]
	{
		if (!$expression)
		{
			throw new IllegalStateException($String->valueOf($errorMessage));
		}
	}
	public static function checkState_14cc2f56 ($expression, $errorMessageTemplate, $errorMessageArgs) // [boolean expression, String errorMessageTemplate, Object... errorMessageArgs]
	{
		if (!$expression)
		{
			throw new IllegalStateException(self::format($errorMessageTemplate, $errorMessageArgs));
		}
	}
	public static function checkNotNull_54 ($reference) // [T reference]
	{
		if (($reference == null))
		{
			throw new NullPointerException();
		}
		return $reference;
	}
	public static function checkNotNull_43b845aa ($reference, $errorMessage) // [T reference, Object errorMessage]
	{
		if (($reference == null))
		{
			throw new NullPointerException($String->valueOf($errorMessage));
		}
		return $reference;
	}
	public static function checkNotNull_4d140682 ($reference, $errorMessageTemplate, $errorMessageArgs) // [T reference, String errorMessageTemplate, Object... errorMessageArgs]
	{
		if (($reference == null))
		{
			throw new NullPointerException(self::format($errorMessageTemplate, $errorMessageArgs));
		}
		return $reference;
	}
	public static function checkElementIndex_74b2cf9f ($index, $size) // [int index, int size]
	{
		return self::checkElementIndex($index, $size, "index");
	}
	public static function checkElementIndex_cdb78d1 ($index, $size, $desc) // [int index, int size, String desc]
	{
		if ((($index < 0) || ($index >= $size)))
		{
			throw new IndexOutOfBoundsException(self::badElementIndex($index, $size, $desc));
		}
		return $index;
	}
	protected static function badElementIndex ($index, $size, $desc) // [int index, int size, String desc]
	{
		if (($index < 0))
		{
			return self::format("%s (%s) must not be negative", $desc, $index);
		}
		else
			if (($size < 0))
			{
				throw new IllegalArgumentException(("negative size: " . $size));
			}
			else
			{
				return self::format("%s (%s) must be less than size (%s)", $desc, $index, $size);
			}
	}
	public static function checkPositionIndex_74b2cf9f ($index, $size) // [int index, int size]
	{
		return self::checkPositionIndex($index, $size, "index");
	}
	public static function checkPositionIndex_cdb78d1 ($index, $size, $desc) // [int index, int size, String desc]
	{
		if ((($index < 0) || ($index > $size)))
		{
			throw new IndexOutOfBoundsException(self::badPositionIndex($index, $size, $desc));
		}
		return $index;
	}
	protected static function badPositionIndex ($index, $size, $desc) // [int index, int size, String desc]
	{
		if (($index < 0))
		{
			return self::format("%s (%s) must not be negative", $desc, $index);
		}
		else
			if (($size < 0))
			{
				throw new IllegalArgumentException(("negative size: " . $size));
			}
			else
			{
				return self::format("%s (%s) must not be greater than size (%s)", $desc, $index, $size);
			}
	}
	public static function checkPositionIndexes ($start, $end, $size) // [int start, int end, int size]
	{
		if (((($start < 0) || ($end < $start)) || ($end > $size)))
		{
			throw new IndexOutOfBoundsException(self::badPositionIndexes($start, $end, $size));
		}
	}
	protected static function badPositionIndexes ($start, $end, $size) // [int start, int end, int size]
	{
		if ((($start < 0) || ($start > $size)))
		{
			return self::badPositionIndex($start, $size, "start index");
		}
		if ((($end < 0) || ($end > $size)))
		{
			return self::badPositionIndex($end, $size, "end index");
		}
		return self::format("end index (%s) must not be less than start index (%s)", $end, $start);
	}
	protected static function format ($template, $args) // [String template, Object... args]
	{
		$template = $String->valueOf($template);
		$builder = new StringBuilder(($template->length() + (16 * count($args) /*from: args.length*/)));
		$templateStart = 0;
		$i = 0;
		while (($i < count($args) /*from: args.length*/)) 
		{
			$placeholderStart = $template->indexOf("%s", $templateStart);
			if (($placeholderStart == -1))
			{
				break;
			}
			$builder->append($template->substring($templateStart, $placeholderStart));
			$builder->append($args[++$i]);
			$templateStart = ($placeholderStart + 2);
		}
		$builder->append($template->substring($templateStart));
		if (($i < count($args) /*from: args.length*/))
		{
			$builder->append(" [");
			$builder->append($args[++$i]);
			while (($i < count($args) /*from: args.length*/)) 
			{
				$builder->append(", ");
				$builder->append($args[++$i]);
			}
			$builder->append(']');
		}
		return $builder->toString();
	}
}
Preconditions::__staticinit(); // initialize static vars for this class on load
?>
