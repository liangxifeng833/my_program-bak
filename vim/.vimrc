set langmenu=zh_CN.UTF-8         "设置菜单语言
source $VIMRUNTIME/delmenu.vim   "导入删除菜单脚本，删除乱码的菜单
source $VIMRUNTIME/menu.vim      "导入正常的菜单脚本
language messages zh_CN.utf-8    "设置提示信息语言

imap ^? <Left><Del>
"set backspace=indent,eol,start
syntax enable
set nu				 "设置行号
set cursorline 			 "设置光标行
syntax on			 "语法高亮
set shortmess=atI		 "去掉欢迎界面
set ai 				 "自动缩进
set si	        		 "智能缩进	
set guioptions-=m		 "不显示菜单栏
set guioptions-=T		 "不显示工具栏toobar
set history=58			 "history文件中需要记录的行数	
set incsearch			 "搜索时高亮显示被查找的内容
set hlsearch			 "搜索时高亮显示被查找的文本
set helplang=cn			 "帮助文档显示中文
set nowrap			 " 不要换行
"colorscheme murphy
"colorscheme desert		 "主题选择，背景色
"colorscheme vividchalk
colorscheme solarized

"tab转换为四个字符
set expandtab
set smarttab
set shiftwidth=4
set tabstop=4

" 设定默认解码
set fenc=utf-8
set encoding=utf-8
let &termencoding=&encoding
set fileencodings=utf-8,gb18030,gbk,gb2312,latin1,usc-bom,euc-jp,cp936,ucs-bom
set fileencoding=utf-8
set fileformats=unix
set confirm                      " 在处理未保存或只读文件的时候，弹出确认
filetype on			 " 侦测文件类型
filetype plugin on  		 " 载入文件类型插件
filetype indent on 		 " 为特定文件类型载入相关缩进文件
set viminfo+=! 			 " 保存全局变量

" 状态行配置
set laststatus=2		 "总是显示状态栏
highlight StatusLine cterm=bold ctermfg=yellow ctermbg=blue
:set statusline=%t%m%r%h%w\ 
":set statusline+=[FORMAT=%{&ff}]\ 
":set statusline+=[TYPE=%Y]\ [ASCII=\%03.3b]\ [HEX=\%02.2B]\ 
:set statusline+=[POS=%04l,%04v,LEN=%L,%p%%]\ 
:set statusline+=<%{&fileencoding}> " encoding

"NERDTree
"autocmd VimEnter * NERDTree /home/lxf/svn		"自动打开并定位到d:\www目录	
let NERDTreeWinPos="left"
let NERDTreeShowBookmarks=1
let NERDChristmasTree=1
let NERDTreeWinSize=25
let NERDTreeShowBookmarks=1
let NERDTreeChDirMode=2 
map <F6> :NERDTreeToggle<CR>
imap <F6> <ESC>:NERDTreeToggle<CR>
nmap <C-s> :NERDTree<cr>
nmap <C-e> :BufExplorer<cr>
nmap <f2>  :BufExplorer<cr>

"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" CTags的设定
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
"set tags=tags
set autochdir			" 自动切换当前目录为当前文件所在目录


"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" Tag list (ctags)
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
"if MySys() == "windows"                "设定windows系统中ctags程序的位置
"let Tlist_Ctags_Cmd = 'ctags'
"elseif MySys() == "linux"              "设定linux系统中ctags程序的位置
"let Tlist_Ctags_Cmd = '/usr/bin/ctags'
"endif
let Tlist_Show_One_File = 1            "不同时显示多个文件的tag，只显示当前文件的
let Tlist_Exit_OnlyWindow = 1          "如果taglist窗口是最后一个窗口，则退出vim
let Tlist_Use_Right_Window = 1         "在右侧窗口中显示taglist窗口 

"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
"php xdebug config 2014-10-26
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
let g:debuggerPort = 9001
let g:debuggerMaxDepth = 5
"let g:dbgPavimPort = 9001
"let g:dbgPavimBreakAtEntry = 0

map <silent> <F9> :TlistToggle<cr>


"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
" 文件设置
"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
"禁止生成临时文件
set nobackup
set noswapfile
"搜索忽略大小写
set ignorecase
"搜索逐字符高亮
set hlsearch
set incsearch

" 字符间插入的像素行数目
set linespace=0

" 增强模式中的命令行自动完成操作
set wildmenu

" 在状态行上显示光标所在位置的行号和列号
set ruler
set rulerformat=%20(%2*%<%f%=\ %m%r\ %3l\ %c\ %p%%%)

" 命令行（在状态行下）的高度，默认为1，这里是2
set cmdheight=2

" 使回格键（backspace）正常处理indent, eol, start等
set backspace=2

" 通过使用: commands命令，告诉我们文件的哪一行被改变过
set report=0


"vim(gvim)支持对齐线-----------------------2012-08-01----start------/
":set cc=80
map ch :call SetColorColumn()<CR>
function! SetColorColumn()
    let col_num = virtcol(".")
    let cc_list = split(&cc, ',')
    if count(cc_list, string(col_num)) <= 0
        execute "set cc+=".col_num
    else
        execute "set cc-=".col_num
    endif
endfunction
"-----------------------------------------------------------end------/

"php语法错误检测-----2012-08-03---------------------------start------/
"方法一
"map <C-J> :!php -l %<CR>  
"方法二
function! CheckPHPSyntax()
    if &filetype != 'php'
        echohl WarningMsg | echo 'This is not a PHP file !' | echohl None
        return
    endif
    setlocal makeprg=/usr/local/php/bin/php\ -l\ -n\ -d\ html_errors=off\ %
    setlocal errorformat=%m\ in\ %f\ on\ line\ %l
    echohl WarningMsg | echo 'Syntax checking output:' | echohl None
    if &modified == 1
        silent write
    endif
    silent make
    clist
endfunction
map <C-J> :call CheckPHPSyntax()<CR>
imap <C-J> <ESC>:call CheckPHPSyntax()<CR>
"-----------------------------------------------------------end------/



"""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
"""""新文件标题
""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""""
"新建.c,.h,.sh,.java文件，自动插入文件头 
autocmd BufNewFile *.cpp,*.[ch],*.sh,*.java,*.py exec ":call SetTitle()" 
""定义函数SetTitle，自动插入文件头 
func SetTitle() 
    call append(line("."),   "########################################################################/") 
    call append(line(".")+1, "# File Name: ".expand("%")) 
    call append(line(".")+2, "# Author: Liangxifeng") 
    call append(line(".")+3, "# Mail: liangxifeng833@163.com ") 
    call append(line(".")+4, "# Created Time: ".strftime("%c")) 
    call append(line(".")+5, "########################################################################/") 
    call append(line(".")+6, "")
	"如果文件类型为.sh文件 
	if &filetype == 'sh' 
		call setline(1,"\#!/bin/bash") 
		"call append(line("."), "") 
    elseif &filetype == 'python'
        call setline(1,"#!/usr/bin/python")
		"call append(line("."), "") 
	elseif &filetype == 'php' 
        call setline(1,"<?php")
		"call append(line(".")+1, "") 
	endif
	if &filetype == 'c'
		call append(line(".")+6, "#include<stdio.h>")
		call append(line(".")+7, "")
	endif

endfunc 
autocmd BufNewFile * normal G


""if has('gui_running')
""    set background=light
""else
""    set background=dark
""endif
set background=dark "配置背景颜色为深色 light为浅色，防止行到一定宽度后背景变红,位置必须放在最后
"set background=light "配置背景颜色为深色 light为浅色，防止行到一定宽度后背景变红,位置必须放在最后
set guifont=Liberation\ Mono\ 10

"插入模式下移动"
inoremap <c-j> <down>
inoremap <c-k> <up>
inoremap <c-l> <right>
inoremap <c-h> <left>
