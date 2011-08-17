<?php

$plugin_info = array(
	'pi_name'			=> 'Contributions Count EE2',
	'pi_version'		=> '1.0',
	'pi_author'			=> 'Nine Four',
	'pi_author_url'		=> 'http://ninefour.co.uk/labs',
	'pi_description'	=> 'Returns the number of contributions made by a member to a specific weblog, something not possible with native tags.',
	'pi_usage'			=> contributions_count::usage()
);

class contributions_count {
	var $return_data;
	function contributions_count() {
                $this->EE =& get_instance();
		
		//collect our parameters
		$author_id = $this->EE->TMPL->fetch_param('author_id');
		$channel_id = $this->EE->TMPL->fetch_param('channel_id');
		$status = $this->EE->TMPL->fetch_param('status');
		$link_url = $this->EE->TMPL->fetch_param('link_url');
		$link_text = $this->EE->TMPL->fetch_param('link_text');
		$link_title = $this->EE->TMPL->fetch_param('link_title');
		$link_class = $this->EE->TMPL->fetch_param('link_class');

		$sql = "SELECT T.entry_id FROM exp_channel_data AS D , exp_channel_titles AS T WHERE T.site_id = '1' AND T.entry_id = D.entry_id AND T.author_id = '" . $author_id . "' AND T.status = '" . $status . "' AND D.channel_id = '" . $channel_id . "'";
                $query = $this->EE->db->query($sql);
		if ($query->num_rows > 0) {

			$data = $query->num_rows;

			if ($link_url!="" AND $link_text!="") {
				$data .= "<a href='".$link_url."'";
				if ($link_title!="") {
					$data .= " title='".$link_title."'";
				}
				if ($link_class!="") {
					$data .= " class='".$link_class."'";
				}
				$data .= " >".$link_text."</a>\r";
			}
		} else {
			$data = '0';
		}

		$this->return_data = $data;
		return $this->return_data;
	}
	function usage() {
                $data = "{exp:contributions_count author_id=\"\" channel_id=\"\" status=\"\" link_url=\"\" link_text=\"\" link_title=\"\" link_class=\"\"}";
                $this->return_data = $data;
                return $this->return_data;
	}
}
?>