<?xml version="1.0" encoding="UTF-8" ?>

<!--
    This stylesheet just copies the XML document to another.
-->

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="xml" indent="yes"/>

    <xsl:template match="*">
        <xsl:copy>
            <xsl:apply-templates select="@*"/>
            <xsl:apply-templates/>
        </xsl:copy>
    </xsl:template>

    <xsl:template match = "@*" > 
           <xsl:copy /> 
    </xsl:template> 

    
</xsl:stylesheet>
