<?php

class Page {
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * 获取分页
     *
     * @param $total_rows 总数
     * @param $per_page   显示几条数据
     * @param $url
     *
     * @return mixed
     */
    public function get_page($total_rows, $per_page, $url) {
        $this->CI->load->library('pagination');
        parse_str($_SERVER['QUERY_STRING'], $query_string);
        unset($query_string['page']);
        $base_url                       = $url . http_build_query($query_string);
        $config['base_url']             = $base_url;
        $config['total_rows']           = $total_rows;
        $config['num_links']            = 5;
        $config['per_page']             = $per_page;
        $config['use_page_numbers']     = true; // 显示实际的页数
        $config['page_query_string']    = true; // 查询字符串格式
        $config['query_string_segment'] = 'page'; // 查询字符串格式


        $config['full_tag_open']  = '<div class="box-footer clearfix"><ul class="pagination pagination-flat no-margin pull-right">';
        $config['full_tag_close'] = '</ul></div>';

        $config['anchor_class'] = "";

        $config['cur_tag_open']  = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';

        $config['prev_tag_open']  = '<li>';
        $config['prev_tag_close'] = '</li>';

        $config['next_tag_open']  = '<li>';
        $config['next_tag_close'] = '</li>';

        $config['first_link']      = '首页';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';

        $config['last_link']      = '尾页';
        $config['last_tag_open']  = '<li>';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = '上一页';
        $config['next_link'] = '下一页';

        $this->CI->pagination->initialize($config);

        return $this->CI->pagination->create_links();
    }

}