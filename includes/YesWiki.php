<?php

    public function Link($tag, $method = "", $text = "", $track = 1)
    {
        $displayText = $text ? $text : $tag;
        // is this an interwiki link?
        if (preg_match('/^' . WN_INTERWIKI_CAPTURE . '$/', $tag, $matches)) {
            if ($tagInterWiki = $this->GetInterWikiUrl($matches[1], $matches[2])) {
                return '<a href="' . htmlspecialchars($tagInterWiki, ENT_COMPAT, YW_CHARSET) . '">' . htmlspecialchars($displayText, ENT_COMPAT, YW_CHARSET) . ' (interwiki)</a>';
            } else {
                return '<a href="' . htmlspecialchars($tag, ENT_COMPAT, YW_CHARSET) . '">' . htmlspecialchars($displayText, ENT_COMPAT, YW_CHARSET) . ' (interwiki inconnu)</a>';
            }
        }  // is this a full link? ie, does it contain non alpha-numeric characters?
          // Note : [:alnum:] is equivalent [0-9A-Za-z]
          // [^[:alnum:]] means : some caracters other than [0-9A-Za-z]
          // For example : "www.adress.com", "mailto:adress@domain.com", "http://www.adress.com"
        else
            if (preg_match('/[^[:alnum:]]/', $tag)) {
                // check for various modifications to perform on $tag
                if (preg_match("/^[\w.-]+\@[\w.-]+$/", $tag)) {
                    // email addresses
                    $tag = 'mailto:' . $tag;
                } else  // Note : in Perl regexp, (?: ... ) is a non-catching cluster
                    if (preg_match('/^[[:alnum:]][[:alnum:].-]*(?:\/|$)/', $tag)) {
                        // protocol-less URLs
                        $tag = 'http://' . $tag;
                    }  // Finally, block script schemes (see RFC 3986 about
                      // schemes) and allow relative link & protocol-full URLs
                    else
                        if (preg_match('/^[a-z0-9.+-]*script[a-z0-9.+-]*:/i', $tag) || ! (preg_match('/^\.?\.?\//', $tag) || preg_match('/^[a-z0-9.+-]+:\/\//i', $tag))) {
                            // If does't fit, we can't qualify $tag as an URL.
                            // There is a high risk that $tag is just XSS (bad
                            // javascript: code) or anything nasty. So we must not
                            // produce any link at all.
                            return htmlspecialchars($tag . ($text ? ' ' . $text : ''), ENT_COMPAT, YW_CHARSET);
                        }
                // Important: Here, we know that $tag is not something bad
                // and that we must produce a link with it

                // An inline image? (text!=tag and url ends by png,gif,jpeg)
                if ($text and preg_match("/\.(gif|jpeg|png|jpg|svg)$/i", $tag)) {
                    return '<img src="' . htmlspecialchars($tag, ENT_COMPAT, YW_CHARSET) . '" alt="' . htmlspecialchars($displayText, ENT_COMPAT, YW_CHARSET) . '"/>';
                } else {
                    // Even if we know $tag is harmless, we MUST encode it
                    // in HTML with htmlspecialchars() before echoing it.
                    // This is not about being paranoiac. This is about
                    // being compliant to the HTML standard.
                    return '<a href="' . htmlspecialchars($tag, ENT_COMPAT, YW_CHARSET) . '">' . htmlspecialchars($displayText, ENT_COMPAT, YW_CHARSET) . '</a>';
                }
            } else {
                // it's a Wiki link!
                if (! empty($track)) {
                    $this->TrackLinkTo($tag);
                }
                // We check the string of right checking in config
                $search_string = $this->config["alter_management_string"];
                $check_string = (empty($search_string)?false:true);
                $checked=false;
                // We check if the string name have the operator
                if ($check_string) {
                    $pos = strpos($displayText, $search_string);
                    if ($pos!==false){
                        $displayText=  substr($displayText,0,$pos);
                        $checked=true;
                    }
                }

                // The Target page is not within the scope rights of the user. Link is ignored.
                if ($checked && ! $this->HasAccess('read', $tag)){
                    return "";
                }
                elseif ($this->LoadPage($tag)) {
                    return '<a href="' . htmlspecialchars($this->href($method, $tag), ENT_COMPAT, YW_CHARSET) . '">' . htmlspecialchars($displayText, ENT_COMPAT, YW_CHARSET) . '</a>';
                }
                else
                {
                    return '<span class="missingpage">' . htmlspecialchars($displayText, ENT_COMPAT, YW_CHARSET) . '</span><a href="' . htmlspecialchars($this->href("edit", $tag), ENT_COMPAT, YW_CHARSET) . '">?</a>';
                }
                ;
            }
    }
