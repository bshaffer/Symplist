<?php

#
# Markdown Extra  -  A text-to-HTML conversion tool for web writers
#
# PHP Markdown & Extra
# Copyright (c) 2004-2008 Michel Fortin  
# <http://www.michelf.com/projects/php-markdown/>
#
# Original Markdown
# Copyright (c) 2004-2006 John Gruber  
# <http://daringfireball.net/projects/markdown/>
#


define( 'MARKDOWN_VERSION',  "1.0.1m" ); # Sat 21 Jun 2008
define( 'MARKDOWNEXTRA_VERSION',  "1.2.3" ); # Wed 31 Dec 2008


#
# Global default settings:
#

# Change to ">" for HTML output
@define( 'MARKDOWN_EMPTY_ELEMENT_SUFFIX',  " />");

# Define the width of a tab for code blocks.
@define( 'MARKDOWN_TAB_WIDTH',     4 );

# Optional title attribute for footnote links and backlinks.
@define( 'MARKDOWN_FN_LINK_TITLE',         "" );
@define( 'MARKDOWN_FN_BACKLINK_TITLE',     "" );

# Optional class attribute for footnote links and backlinks.
@define( 'MARKDOWN_FN_LINK_CLASS',         "" );
@define( 'MARKDOWN_FN_BACKLINK_CLASS',     "" );


#
# WordPress settings:
#

# Change to false to remove Markdown from posts and/or comments.
@define( 'MARKDOWN_WP_POSTS',      true );
@define( 'MARKDOWN_WP_COMMENTS',   true );



### Standard Function Interface ###

@define( 'MARKDOWN_PARSER_CLASS',  'MarkdownExtra_Parser' );
