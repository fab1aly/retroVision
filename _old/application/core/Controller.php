<?php

	abstract class Controller
	{
		protected function renderView(string $view, array $data = [], ?string $layout = 'base.phtml'): void
		{
			extract($data);

			if($layout !== null)
			{
				ob_start();
				require ROOT.'/application/views/'.$view;
				$viewContent = ob_get_clean();

				require ROOT.'/application/views/layouts/'.$layout;
			}
			else
			{
				require ROOT.'/application/views/'.$view;
			}
		}
	}