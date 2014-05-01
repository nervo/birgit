<?php

namespace Birgit\Component;

/**
 * Parameters
 */
abstract class Parameters
{
	protected $parameters = array();

	protected function get($parameter, $default = null)
	{
		if (!$this->has($parameter)) {
			return $default;
		}

		return $this->parameters[(string) $parameter];
	}

	protected function set($parameter, $value)
	{
		$this->parameters[(string) $parameter] = $value;

		return $this;
	}

	protected function has($parameter)
	{
		return array_key_exists((string) $parameter, $this->parameters);
	}

	public function merge(array $parameters)
	{
		$this->parameters = array_merge(
			$this->parameters,
			$parameters
		);

		return $this;
	}
}
