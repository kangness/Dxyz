#Dxyz
ʹ����ͬ�Ĵ��뿪�� DiscuzX 1.5 ~ 2.5 ��չ

##�ļ���Դ
����ļ���ȡ�� Discuz X2.5/20120701 , ��������Ҫ�޸�.

##ʹ�÷���
 * ����ļ���ͨ�� DiscuzX �Դ���ڣ��� *plugin.php | admin.php*�����ã���������´������:
    ```php
    <?php
    require_once DISCUZ_ROOT . '/dxyz/init.php';

    //Type your code here.
    ```
 * ����ļ��Ƕ�����ڣ���������´������:
    ```php
    <?php
    require './source/class/class_core.php';
    require './source/function/function_forum.php';

    require './dxyz/init.php';

    $discuz = C::app();
    $discuz->init();

    //Type your code here.
    ```
 * �������Ҫȡ�� X1.5/X2 �� *$_GET | $_POST | $_COOKIE* �ķ�б�ߴ�������***���� /dxyz/init.php ��***����`dxyz_input();`  
   ����Ƕ�������ļ����������`$discuz->init();`֮��ʹ�øú���
   �벻Ҫ��Ϊ X2.5 ���°汾��д����չ��ʹ�ñ���������Ϊ��Щ��չ�ǰ��� *$_GET | $_POST | $_COOKIE* �Ѿ�������б�ߴ���������д�ģ�����Щ��չ�е��ñ��������ܻ����� SQL ����©����

##ע������
 * ��д���ݲ��ļ�ʱ����ʹ�� Dxyz_DB ����� DB �ࡣ
 * ��д�����װ�ļ��������԰�ʱ����ֱ��ʹ�� $installlang['english'] ��X1.5 Ĭ�ϸ�ʽ�� $installlang['plugin_iden']['english']��
 * ����ܽ��Դ�����Ч�����Է���ļ�������д������ʱ�������п��ǰ汾������졣
 * ������Ѱ��� X2.5 ����������ϵͳ���ݲ��ļ�����������ݱ��ֶο��ܲ������������ڰ汾�С�ʹ��������ݿ���ʱ�����в��ԡ�

##�汾��¼
###Version - 0.1 Beta:
 * ʵ�� X1.5/X2 �����ݲ��֧��
 * ���� X1.5 �����װ���������԰���ȡ��ʽ
 * ���� X1.5/X2 �� Core ��Ĳ���֧��
 * ���� X1.5/X2 ��ȡ����б�ߵĺ���