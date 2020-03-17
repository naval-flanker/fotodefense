				</main>
			</div>
			<footer class="footer bb" itemscope itemtype="http://schema.org/Organization">
				<?$APPLICATION->IncludeComponent(
						"bitrix:menu", 
						"fotodefense_top_menu", 
						array(
							"ALLOW_MULTI_SELECT" => "N",
							"CHILD_MENU_TYPE" => "left",
							"DELAY" => "N",
							"MAX_LEVEL" => "1",
							"MENU_CACHE_GET_VARS" => array(
							),
							"MENU_CACHE_TIME" => "3600",
							"MENU_CACHE_TYPE" => "N",
							"MENU_CACHE_USE_GROUPS" => "Y",
							"ROOT_MENU_TYPE" => "top",
							"USE_EXT" => "Y",
							"COMPONENT_TEMPLATE" => "fotodefense_top_menu",
							"NO_ADD_ADAPTIVE_MENU" => "Y"
						),
						false
					);
				?>
				<div class="footer_content nx-flex-row-btw-c">
					<address class="copy">
						<div class="wrap_copy-data">©<span class="copy-data"></span> Женский журнал</div>
						<div>Копирование материалов запрещено</div>
					</address>
				</div>
			</footer> 
		</div>
	</body>
</html>