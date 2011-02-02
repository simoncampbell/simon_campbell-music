{exp:rss:feed weblog="journal_notes|journal_audio|journal_videos|journal_photos"}

<?xml version="1.0" encoding="{encoding}"?>
<rss version="2.0"
    xmlns:dc="http://purl.org/dc/elements/1.1/"
    xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
    xmlns:admin="http://webns.net/mvcb/"
    xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
    xmlns:content="http://purl.org/rss/1.0/modules/content/">

    <channel>
    
    <title>{exp:xml_encode}Simon Campbell Music{/exp:xml_encode}</title>
    <link>{weblog_url}</link>
    <description>Simon's music journal.</description>
    <dc:language>{weblog_language}</dc:language>
    <dc:creator>{email}</dc:creator>
    <dc:rights>Copyright {gmt_date format="%Y"}</dc:rights>
    <dc:date>{gmt_date format="%Y-%m-%dT%H:%i:%s%Q"}</dc:date>
    <admin:generatorAgent rdf:resource="http://www.pmachine.com/" />
    
{exp:weblog:entries 
    disable="member_data|pagination|trackbacks" 
    weblog="journal_notes|journal_audio|journal_videos|journal_photos" 
    limit="10" 
    rdf="off" 
    dynamic_start="on" 
    disable="member_data|trackbacks" 
    status="Open"
    }
    <item>
      <title>{exp:xml_encode}{title}{/exp:xml_encode}</title>
      <link>{site_url}{comment_url_title_auto_path}</link>
      <guid>{site_url}{comment_url_title_auto_path}#When:{gmt_entry_date format="%H:%i:%sZ"}</guid>
      <description><![CDATA[
          
          {cf_journal_videos_lead}{cf_journal_photos_lead}{cf_journal_audio_lead}{cf_journal_notes_note}
          
          <p><a href="{site_url}{comment_url_title_auto_path}">Read more in the journal...</a></p>
        
        ]]></description>
      <dc:date>{gmt_entry_date format="%Y-%m-%dT%H:%i:%s%Q"}</dc:date>
    </item>
{/exp:weblog:entries}
    
    </channel>
</rss>

{/exp:rss:feed}