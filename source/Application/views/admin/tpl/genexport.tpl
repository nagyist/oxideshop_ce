[{if $linenr == 0}]
[{if $sCustomHeader}][{$sCustomHeader}]<br>[{/if}]
[{/if}]
[{$article->oxarticles__oxartnum->value|oxenclose:$encl}][{$spr}][{$article->oxarticles__oxtitle->value|strip_tags|oxenclose:$encl}][{$spr}][{$article->oxcategories__oxtitle->value|strip_tags|oxenclose:$encl}][{$spr}][{$article->oxarticles__oxshortdesc->value|strip_tags|oxenclose:$encl}][{$spr}][{$article->getLongDesc()|strip_tags|oxenclose:$encl}][{$spr}][{$article->pic1}][{$spr}][{$article->oxarticles__oxtprice->value}][{$spr}][{$article->getFPrice()}][{$spr}][{$article->valid}][{$spr}][{$article->getLink()|replace:"&amp;":"&" nofilter}]
