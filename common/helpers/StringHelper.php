<?php

namespace common\helpers;

class StringHelper extends \yii\helpers\StringHelper
{
	/**
	 * @param string $string
	 * @param int $length
	 * @param string $suffix
	 * @param null|string $encoding
	 * @param bool $asHtml
	 * @return string
	 */
	public static function smartTruncate($string, $length, $suffix = '...', $encoding = null, $asHtml = false)
	{
        if ($string === null){
            return null;
        }
		if (mb_strlen($string) <= $length) {
			return $string;
		}

		$string = static::truncate($string, $length, $suffix, $encoding, $asHtml);

		$lasSpacePos = mb_strrpos($string, ' ');

        return rtrim(mb_substr($string, 0, $lasSpacePos)) . $suffix;
	}

	/**
	 * @param string $string
	 * @return string
	 */
	public static function spaceless($string)
	{
		return trim(preg_replace('/>\s+</', '><', $string));
	}

    /**
     * @param string $string
     * @param int $length
     * @return string
     */
	public static function hardTruncate($string, $length = 80)
    {
        if ($string === null){
            return null;
        }

        if (mb_strlen($string) <= $length) {
            return $string;
        }

        return substr($string, 0, $length) . '...';
    }

    public static function getPartBeforeLastDelimiter(string $value, string $delimiter)
    {
        $split = explode($delimiter, $value);
        unset($split[count($split) - 1]);
        return join($delimiter, $split);
    }
}
