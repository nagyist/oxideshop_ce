[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink() nofilter}]" method="post">
    [{$oViewConf->getHiddenSid() nofilter}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="article_crossselling">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>


<form name="myedit" id="myedit" action="[{$oViewConf->getSelfLink() nofilter}]" method="post">
[{$oViewConf->getHiddenSid() nofilter}]
<input type="hidden" name="cl" value="article_crossselling">
<input type="hidden" name="fnc" value="">
<input type="hidden" name="oxid" value="[{$oxid}]">
<input type="hidden" name="editval[article__oxid]" value="[{$oxid}]">
<input type="hidden" name="voxid" value="[{$oxid}]">
<input type="hidden" name="oxparentid" value="[{$oxparentid}]">
<input type="hidden" name="sorting" value="">
<input type="hidden" name="stable" value="">
<input type="hidden" name="starget" value="">

  <table cellspacing="0" cellpadding="0" border="0" width="98%">

    <tr>
      <td valign="top" class="edittext">
        [{block name="admin_article_crossselling_assign_crossselling"}]
          [{oxhasrights object=$edit readonly=$readonly}]
            <input type="button" value="[{oxmultilang ident="ARTICLE_CROSSSELLING_ASSIGNCROSSSELLING"}]" class="edittext" onclick="JavaScript:showDialog('&cl=article_crossselling&aoc=1&oxid=[{$oxid}]');" [{$readonly}]>
          [{/oxhasrights}]
        [{/block}]
      </td>
      <!-- Anfang rechte Seite -->
      <td valign="top" class="edittext" align="left" width="50%">
        [{block name="admin_article_crossselling_assign_accessoires"}]
          [{oxhasrights object=$edit readonly=$readonly}]
            <input type="button" value="[{oxmultilang ident="ARTICLE_CROSSSELLING_ASSIGNACCESSORIES"}]" class="edittext" onclick="JavaScript:showDialog('&cl=article_crossselling&aoc=2&oxid=[{$oxid}]');" [{$readonly}]>
          [{/oxhasrights}]
        [{/block}]
      </td>
      <!-- Ende rechte Seite -->
    </tr>
  </table>
</form>
[{include file="bottomnaviitem.tpl"}]

[{include file="bottomitem.tpl"}]
