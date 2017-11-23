<?php

class Page {
    protected $CI;
    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * 获取分页
     * @param $total_rows 总数
     * @param $per_page 显示几条数据
     * @param $url
     * @return mixed
     */
    public function get_page($total_rows , $per_page, $url){
        $this->CI->load->library('pagination');
        parse_str($_SERVER['QUERY_STRING'], $query_string);
        unset($query_string['page']);
        $base_url = $url . http_build_query($query_string);
        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['num_links'] = 3;
        $config['per_page'] = $per_page;
        $config['use_page_numbers'] = true; // 显示实际的页数
        $config['page_query_string'] = true; // 查询字符串格式
        $config['query_string_segment'] = 'page'; // 查询字符串格式

        $config['full_tag_open'] = '<ul class="pagination pull-right">';
        $config['full_tag_close'] = '</ul>';

        $config['first_link'] = '第一页';
        $config['last_link'] = '尾页';
        //$config['first_link'] = false;
        //$config['last_link'] = false;
        $config['prev_tag_open'] = '';
        $config['prev_tag_close'] = '';
        $config['prev_link'] = '上一页';
        $config['next_tag_open'] = '';
        $config['next_tag_close'] = '';
        $config['next_link'] = '›';
        $config['cur_tag_open'] = '<span class="current">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '';
        $config['num_tag_close'] = '';
        $this->CI->pagination->initialize($config);

        $data['show_page'] = $this->CI->pagination->create_links();
        $data['base_url'] = $base_url;
        return $data;
    }
} 